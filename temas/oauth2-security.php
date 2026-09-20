<?php
  $is_standalone = empty($in_bloque_context);
  if ($is_standalone) {
    include_once __DIR__ . '/../components/header.php';
    include_once __DIR__ . '/../components/sidebar.php';
  }
?>

<?php if ($is_standalone): ?>
    <main class="main-wrapper markdown-body">
      <div class="content-grid">
        <div class="content-main">
<?php endif; ?>

<article id="tema-20">
  <h3>20 — Arquitectura de Seguridad Avanzada con Spring Security 6 & OAuth2</h3>

  <details class="topic-dropdown">
    <summary class="topic-dropdown-trigger">
      <svg class="topic-dropdown-icon" width="14" height="14" viewBox="0 0 16 16" fill="currentColor">
        <path d="M2 3.75C2 2.784 2.784 2 3.75 2h8.5c.966 0 1.75.784 1.75 1.75v8.5A1.75 1.75 0 0 1 12.25 14h-8.5A1.75 1.75 0 0 1 2 12.25Zm1.75-.25a.25.25 0 0 0-.25.25v8.5c0 .138.112.25.25.25h8.5a.25.25 0 0 0 .25-.25v-8.5a.25.25 0 0 0-.25-.25ZM4.5 5.5h7v1.5h-7Zm0 3.5h7v1.5h-7Z"/>
      </svg>
      <span>Apartados de este tema</span>
      <span class="topic-dropdown-caret">▼</span>
    </summary>
    <div class="topic-dropdown-menu">
      <div class="topic-dropdown-header">20. OAuth2 & Security 6</div>
      <a href="#tema-20-security6" class="topic-dropdown-item"><span class="item-num">20.1</span> <span class="item-title">Configuración Funcional de SecurityFilterChain en Spring Security 6</span></a>
      <a href="#tema-20-resource-server" class="topic-dropdown-item"><span class="item-num">20.2</span> <span class="item-title">Configuración como OAuth2 Resource Server con JWT</span></a>
      <a href="#tema-20-authorities" class="topic-dropdown-item"><span class="item-num">20.3</span> <span class="item-title">Mapeo Personalizado de Claims y Roles (GrantedAuthoritiesConverter)</span></a>
      <a href="#tema-20-cors-csrf" class="topic-dropdown-item"><span class="item-num">20.4</span> <span class="item-title">Estrategias de CORS y CSRF para APIs Stateless y Frontends SPA</span></a>
    </div>
  </details>

  <p class="topic-intro">
    Spring Security 6 (incluido en Spring Boot 3) elimina por completo el uso de clases adaptadoras obsoletas (como <code>WebSecurityConfigurerAdapter</code>) en favor de un modelo estrictamente basado en la declaración de beans de la interfaz <code>SecurityFilterChain</code> y estilo lambda fluido.
  </p>

  <h4 id="tema-20-analogia">20.0 Intuición de la Vida Real: La Llave de Hotel Magnética y la Llave del Aparcacoches</h4>
  <github-alert type="note" title="💡 Modelo Mental: OAuth2 y Tokens JWT en la vida real">
    <p>
      Imagina que llegas a un hotel de lujo en tus vacaciones:
    </p>
    <ul>
      <li><strong>Contraseña Directa (Inseguro)</strong>: Darle la contraseña de tu cuenta bancaria a un sitio web de viajes para que compruebe tu saldo es como darle la llave maestra de tu casa al recepcionista del hotel.</li>
      <li><strong>La Llave de Tarjeta del Hotel (JWT Access Token)</strong>: Al hacer check-in (autenticación en Google/Keycloak), la recepción te da una tarjeta de plástico programada. Esa tarjeta contiene metadatos firmados digitalmente (Claims/JWT): <code>Habitación: 402</code>, <code>Caduca: Mañana 12:00</code>, <code>Permisos: [Piscina, Gimnasio]</code>. La puerta de la piscina no llama por teléfono a la recepción cada vez que entras; solo escanea el chip criptográfico de tu tarjeta.</li>
      <li><strong>La Llave de Aparcacoches (OAuth2 Scopes)</strong>: Cuando le das la llave de tu coche al botones del hotel para que aparque, le entregas una "llave de aparcacoches" especial (Scope: <code>drive_only</code>) que permite arrancar el motor y aparcar, pero NO permite abrir el maletero donde guardas tus maletas.</li>
    </ul>
  </github-alert>

  <h4 id="tema-20-security6">20.1 Configuración Funcional de SecurityFilterChain en Spring Security 6</h4>
  <p>
    El siguiente ejemplo demuestra la configuración de autorización mediante DSL funcional con expresiones lambda.
  </p>

  <div class="code-block-header">Ejemplo: SecurityFilterChain Moderno</div>
  <pre><code class="language-java">@Configuration
@EnableWebSecurity
@EnableMethodSecurity
public class SecurityConfig {

    @Bean
    public SecurityFilterChain filterChain(HttpSecurity http) throws Exception {
        http
            .csrf(AbstractHttpConfigurer::disable)
            .sessionManagement(session -&gt; session.sessionCreationPolicy(SessionCreationPolicy.STATELESS))
            .authorizeHttpRequests(auth -&gt; auth
                .requestMatchers("/public/**", "/actuator/health", "/swagger-ui/**", "/v3/api-docs/**").permitAll()
                .requestMatchers("/api/admin/**").hasRole("ADMIN")
                .anyRequest().authenticated()
            );

        return http.build();
    }
}</code></pre>

  <h4 id="tema-20-resource-server">20.2 Configuración como OAuth2 Resource Server con JWT</h4>
  <p>
    Para validar tokens emitidos por Proveedores de Identidad (IdP) como Keycloak, Auth0 u Okta, Spring Security valida la firma del token mediante la clave pública (JWK Set URI) especificada en la configuración.
  </p>

  <pre><code class="language-yaml"># application.yml
spring:
  security:
    oauth2:
      resourceserver:
        jwt:
          issuer-uri: https://auth.empresa.com/realms/mi-realm
          jwk-set-uri: https://auth.empresa.com/realms/mi-realm/protocol/openid-connect/certs</code></pre>

  <h4 id="tema-20-authorities">20.3 Mapeo Personalizado de Claims y Roles (GrantedAuthoritiesConverter)</h4>
  <p>
    Los tokens JWT de proveedores de identidad suelen incluir los roles en estructuras JSON compuestas (ej. <code>realm_access.roles</code> en Keycloak). Para que anotaciones como <code>@PreAuthorize("hasRole('ADMIN')")</code> funcionen, debemos personalizar el conversor de autoridades:
  </p>

  <pre><code class="language-java">@Bean
public JwtAuthenticationConverter jwtAuthenticationConverter() {
    JwtGrantedAuthoritiesConverter defaultGrantedAuthoritiesConverter = new JwtGrantedAuthoritiesConverter();
    
    Converter&lt;Jwt, Collection&lt;GrantedAuthority&gt;&gt; customConverter = jwt -&gt; {
        Collection&lt;GrantedAuthority&gt; authorities = defaultGrantedAuthoritiesConverter.convert(jwt);
        
        // Extracción de roles desde el claim 'realm_access'
        Map&lt;String, Object&gt; realmAccess = jwt.getClaim("realm_access");
        if (realmAccess != null && realmAccess.containsKey("roles")) {
            List&lt;String&gt; roles = (List&lt;String&gt;) realmAccess.get("roles");
            List&lt;SimpleGrantedAuthority&gt; keycloakRoles = roles.stream()
                .map(role -&gt; new SimpleGrantedAuthority("ROLE_" + role.toUpperCase()))
                .collect(Collectors.toList());
            authorities.addAll(keycloakRoles);
        }
        return authorities;
    };

    JwtAuthenticationConverter jwtAuthenticationConverter = new JwtAuthenticationConverter();
    jwtAuthenticationConverter.setJwtGrantedAuthoritiesConverter(customConverter);
    return jwtAuthenticationConverter;
}</code></pre>

  <h4 id="tema-20-cors-csrf">20.4 Estrategias de CORS y CSRF para APIs Stateless y Frontends SPA</h4>
  <p>
    En arquitecturas API REST desacopladas servidas a clientes SPA (React/Angular), se debe habilitar una configuración CORS explícita para dominios permitidos:
  </p>

  <pre><code class="language-java">@Bean
public CorsConfigurationSource corsConfigurationSource() {
    CorsConfiguration configuration = new CorsConfiguration();
    configuration.setAllowedOrigins(List.of("https://app.empresa.com", "http://localhost:3000"));
    configuration.setAllowedMethods(List.of("GET", "POST", "PUT", "DELETE", "OPTIONS"));
    configuration.setAllowedHeaders(List.of("Authorization", "Content-Type", "X-Requested-With"));
    configuration.setAllowCredentials(true);
    
    UrlBasedCorsConfigurationSource source = new UrlBasedCorsConfigurationSource();
    source.registerCorsConfiguration("/**", configuration);
    return source;
}</code></pre>

  <github-alert type="important" title="Migración a Spring Security 6">
    <p>
      Recuerda que en Spring Security 6 todas las invocaciones a métodos de configuración de <code>HttpSecurity</code> deben utilizar sintaxis lambda. Los métodos encadenados imperativos tradicionales (como <code>.and().authorizeRequests()</code>) han sido completamente eliminados.
    </p>
  </github-alert>
</article>

<?php if ($is_standalone): ?>
        </div>
      </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
<?php endif; ?>

