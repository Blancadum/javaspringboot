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

<article id="tema-15">
          <h3>15 — JWT y Contenedorización con Docker</h3>

          <details class="topic-dropdown">
          <summary class="topic-dropdown-trigger">
            <svg class="topic-dropdown-icon" width="14" height="14" viewBox="0 0 16 16" fill="currentColor">
              <path d="M2 3.75C2 2.784 2.784 2 3.75 2h8.5c.966 0 1.75.784 1.75 1.75v8.5A1.75 1.75 0 0 1 12.25 14h-8.5A1.75 1.75 0 0 1 2 12.25Zm1.75-.25a.25.25 0 0 0-.25.25v8.5c0 .138.112.25.25.25h8.5a.25.25 0 0 0 .25-.25v-8.5a.25.25 0 0 0-.25-.25ZM4.5 5.5h7v1.5h-7Zm0 3.5h7v1.5h-7Z"/>
            </svg>
            <span>Apartados de este tema</span>
            <span class="topic-dropdown-caret">▼</span>
          </summary>
          <div class="topic-dropdown-menu">
            <div class="topic-dropdown-header">15. Seguridad, Docker & Microservicios</div>
            <a href="#tema-15-jwt" class="topic-dropdown-item"><span class="item-num">15.1</span> <span class="item-title">Seguridad Stateless con JWT</span></a>
            <a href="#tema-15-securityfilter" class="topic-dropdown-item"><span class="item-num">15.2</span> <span class="item-title">Configuración del SecurityFilterChain</span></a>
            <a href="#tema-15-security-best-practices" class="topic-dropdown-item"><span class="item-num">15.3</span> <span class="item-title">Prácticas de Seguridad: BCrypt, RBAC (@PreAuthorize) y CORS</span></a>
            <a href="#tema-15-docker" class="topic-dropdown-item"><span class="item-num">15.4</span> <span class="item-title">Dockerfile Multi-Stage Optimizado</span></a>
            <a href="#tema-15-microservicios" class="topic-dropdown-item"><span class="item-num">15.5</span> <span class="item-title">Comunicación entre Microservicios: Síncrona vs Asíncrona</span></a>
            <a href="#tema-15-monitoreo" class="topic-dropdown-item"><span class="item-num">15.6</span> <span class="item-title">Monitoreo y Gestión del Rendimiento (Actuator)</span></a>
          </div>
        </details>

          <p class="topic-intro">
            El ciclo de desarrollo culmina protegiendo la aplicación y empaquetándola para su distribución en la nube. Este tema enseña a implementar seguridad stateless con Spring Security y tokens JWT, hashing seguro con BCrypt, autorización basada en roles (RBAC), empaquetado multi-stage ultra ligero en Docker, y los fundamentos de integración en microservicios (síncronos vs asíncronos con Kafka/RabbitMQ).
          </p>

          <div class="tip-box" style="background: var(--color-canvas-subtle); border-left: 4px solid var(--color-primer-border-active); padding: 16px 20px; margin: 20px 0; border-radius: 6px;">
            <h5 style="margin-top: 0; margin-bottom: 8px; font-size: 15px; color: var(--color-fg-default); display: flex; align-items: center; gap: 8px;">
              <span>💡</span> <strong>Intuición para Principiantes: Seguridad Stateless y Microservicios (El billete de tren con código QR y la cocina del restaurante)</strong>
            </h5>
            <p style="margin-bottom: 10px; font-size: 13.5px; line-height: 1.6;">
              Seguridad y Microservicios suelen asustar a quienes entran por primera vez al mundo backend, pero sus principios fundamentales son muy intuitivos si los comparamos con situaciones cotidianas:
            </p>
            <p style="margin-bottom: 10px; font-size: 13.5px; line-height: 1.6;">
              <strong>1. Seguridad Stateful (El guardarropa clásico) vs Stateless con JWT (El billete con código QR):</strong>
            </p>
            <ul style="margin-bottom: 10px; font-size: 13.5px; line-height: 1.6; padding-left: 20px;">
              <li><strong>Antiguo (Stateful / Sesiones en memoria)</strong>: Cuando hacías login, el servidor guardaba tus datos en su propia memoria RAM y te daba una cookie (<code class="kw">JSESSIONID</code>). ¿El problema? Si <strong>BiblioTech</strong> crece y tienes 5 servidores detrás de un balanceador de carga, si la segunda petición llega al servidor #2, ¡éste no sabe quién eres porque tu sesión está en la memoria del servidor #1!</li>
              <li><strong>Moderno (Stateless / JWT)</strong>: Como un billete de tren de alta velocidad con código QR. El billete lleva impreso tu nombre, asiento y clase VIP (tus roles), sellado con una <strong>firma criptográfica matemática</strong> que nadie puede falsificar sin la clave secreta de la compañía. El revisor no necesita consultar ninguna base de datos central: escanea el código, valida la firma al milisegundo y te deja pasar. En Spring Boot, el cliente envía <code class="kw">Authorization: Bearer &lt;token&gt;</code> y el servidor valida el token sin tocar la base de datos ni consumir memoria en RAM (<code class="kw">SessionCreationPolicy.STATELESS</code>).</li>
            </ul>
            <p style="margin-bottom: 10px; font-size: 13.5px; line-height: 1.6;">
              <strong>2. Síncrono vs Asíncrono en Microservicios (Llamada de teléfono vs Comanda de restaurante):</strong>
            </p>
            <ul style="margin-bottom: 0; font-size: 13.5px; line-height: 1.6; padding-left: 20px;">
              <li><strong>Comunicación Síncrona (REST)</strong>: Como llamar por teléfono. El camarero llama al cocinero y se queda esperando al teléfono sin atender a nadie hasta que el cocinero descuelga y contesta. Si la línea se corta, todo el pedido fracasa.</li>
              <li><strong>Comunicación Asíncrona (Event-Driven con Kafka)</strong>: El camarero escribe una comanda (<code class="kw">LibroPrestadoEvent</code>), la cuelga en el tablón de pedidos (Topic de Kafka <code class="kw">bibliotech-prestamos</code>) y continúa atendiendo a otros clientes al instante. La cocina y la barra de bebidas toman la comanda a su ritmo sin bloquear al camarero.</li>
            </ul>
          </div>

          <h4 id="tema-15-jwt">15.1 Seguridad Stateless con JWT</h4>
          <p>
            En una arquitectura REST stateless, el cliente obtiene un JWT firmado y lo transmite en cada solicitud subsiguiente dentro de la cabecera <code class="kw">Authorization: Bearer &lt;token&gt;</code>.
          </p>

          <h4 id="tema-15-securityfilter">15.2 Configuración del SecurityFilterChain</h4>
          <code-block lang="java">
<pre><code><span class="ann">@Configuration</span>
<pre><code><span class="kw">package</span> com.bibliotech.config;

<span class="kw">import</span> com.bibliotech.security.<span class="typ">JwtFiltro</span>;
<span class="kw>import</span> org.springframework.context.annotation.<span class="typ">Bean</span>;
<span class="kw">import</span> org.springframework.context.annotation.<span class="typ">Configuration</span>;
<span class="kw">import</span> org.springframework.http.<span class="typ">HttpMethod</span>;
<span class="kw">import</span> org.springframework.security.config.annotation.web.builders.<span class="typ">HttpSecurity</span>;
<span class="kw">import</span> org.springframework.security.config.annotation.web.configuration.<span class="typ">EnableWebSecurity</span>;
<span class="kw">import</span> org.springframework.security.config.http.<span class="typ">SessionCreationPolicy</span>;
<span class="kw">import</span> org.springframework.security.web.<span class="typ">SecurityFilterChain</span>;
<span class="kw">import</span> org.springframework.security.web.authentication.<span class="typ">UsernamePasswordAuthenticationFilter</span>;

<span class="ann">@Configuration</span>
<span class="ann">@EnableWebSecurity</span>
<span class="kw">public class</span> <span class="typ">SecurityConfig</span> {

    <span class="ann">@Bean</span>
    <span class="kw">public</span> <span class="typ">SecurityFilterChain</span> <span class="fn">securityFilterChain</span>(<span class="typ">HttpSecurity</span> http, <span class="typ">JwtFiltro</span> jwtFiltro) <span class="kw">throws</span> <span class="typ">Exception</span> {
        <span class="kw">return</span> http
            .<span class="fn">csrf</span>(csrf -&gt; csrf.<span class="fn">disable</span>())
            .<span class="fn">sessionManagement</span>(sm -&gt; sm.<span class="fn">sessionCreationPolicy</span>(<span class="typ">SessionCreationPolicy</span>.STATELESS))
            .<span class="fn">authorizeHttpRequests</span>(auth -&gt; auth
                <span class="cmt">// 1. Endpoints públicos: Autenticación, Swagger y consulta de libros</span>
                .<span class="fn">requestMatchers</span>(<span class="str">"/api/v1/auth/**"</span>, <span class="str">"/swagger-ui/**"</span>, <span class="str">"/v3/api-docs/**"</span>).<span class="fn">permitAll</span>()
                .<span class="fn">requestMatchers</span>(<span class="typ">HttpMethod</span>.DELETE, <span class="str">"/api/v1/**"</span>).<span class="fn">hasRole</span>(<span class="str">"ADMIN"</span>)
                .<span class="fn">requestMatchers</span>(<span class="typ">HttpMethod</span>.GET, <span class="str">"/api/v1/libros/**"</span>).<span class="fn">permitAll</span>()
                <span class="cmt">// 2. Gestión de catálogo reservada a bibliotecarios y administradores</span>
                .<span class="fn">requestMatchers</span>(<span class="typ">HttpMethod</span>.POST, <span class="str">"/api/v1/libros/**"</span>).<span class="fn">hasAnyRole</span>(<span class="str">"BIBLIOTECARIO"</span>, <span class="str">"ADMIN"</span>)
                .<span class="fn">requestMatchers</span>(<span class="typ">HttpMethod</span>.PUT, <span class="str">"/api/v1/libros/**"</span>).<span class="fn">hasAnyRole</span>(<span class="str">"BIBLIOTECARIO"</span>, <span class="str">"ADMIN"</span>)
                .<span class="fn">requestMatchers</span>(<span class="typ">HttpMethod</span>.DELETE, <span class="str">"/api/v1/libros/**"</span>).<span class="fn">hasRole</span> ( <span class="str">"ADMIN"</span> )
                <span class="cmt">// 3. Cualquier otra petición exige usuario autenticado</span>
                .<span class="fn">anyRequest</span>().<span class="fn">authenticated</span>()
            )
            .<span class="fn">addFilterBefore</span>(jwtFiltro, <span class="typ">UsernamePasswordAuthenticationFilter</span>.<span class="kw">class</span>)
            .<span class="fn">build</span>();
    }
}</code></pre>
          </code-block>


          <h4 id="tema-15-security-best-practices">15.3 Prácticas de Seguridad: Hashing con BCrypt, RBAC (@PreAuthorize) y CORS</h4>
          <p>
            La seguridad empresarial en Spring Boot abarca múltiples capas defensivas indispensables para la plataforma BiblioTech:
          </p>
          <ul>
            <li><strong>Hashing Criptográfico de Contraseñas con BCrypt</strong>:
              Nunca se deben almacenar contraseñas en texto claro. <code class="kw">BCryptPasswordEncoder</code> incorpora una sal (salt) aleatoria única por credencial y un factor de trabajo (work factor) configurable:
              <pre><code>@Bean
public PasswordEncoder passwordEncoder() {
    return new BCryptPasswordEncoder(12);
}</code></pre>
            </li>
            <li><strong>Control de Acceso Basado en Roles (RBAC) con @PreAuthorize</strong>:
              Al habilitar <code class="kw">@EnableMethodSecurity</code> en la configuración, los métodos de servicios y endpoints de BiblioTech se protegen granularmente:
              <pre><code>@PreAuthorize("hasRole('BIBLIOTECARIO')")
@PostMapping("/api/v1/libros")
public ResponseEntity&lt;LibroResponseDTO&gt; registrarLibro(@Valid @RequestBody LibroRequestDTO dto) { ... }

@PreAuthorize("hasAnyRole('GERENTE', 'AUDITOR') or #username == authentication.name")
@GetMapping("/reportes/{username}")
public ReporteDTO verReporte(@PathVariable String username) { ... }</code></pre>
            </li>
            <li><strong>Protección CORS y CSRF</strong>:
              En APIs REST desacopladas sin estado (stateless) autenticadas por JWT en cabeceras HTTP, se desactiva CSRF (<code class="kw">csrf.disable()</code>) y se define una política estricta con <code class="kw">CorsConfigurationSource</code> permitiendo únicamente los orígenes frontend y métodos legítimos.
            </li>
          </ul>

          <h4 id="tema-15-docker">15.4 Dockerfile Multi-Stage Optimizado</h4>
          <code-block lang="dockerfile">
<pre><code><span class="cmt"># ── ETAPA 1: Compilación (Build) ──────────────────────────</span>
<span class="kw">FROM</span> maven:3.9-eclipse-temurin-21-alpine <span class="kw">AS</span> builder
<span class="kw">WORKDIR</span> /app
<span class="kw">COPY</span> pom.xml .
<span class="kw">RUN</span> mvn dependency:go-offline -B
<span class="kw">COPY</span> src ./src
<span class="kw">RUN</span> mvn clean package -DskipTests

<span class="cmt"># ── ETAPA 2: Imagen Final Ligera ──────────────────────────</span>
<span class="kw">FROM</span> eclipse-temurin:21-jre-alpine
<span class="kw">WORKDIR</span> /app
<span class="kw">RUN</span> addgroup -S appgroup && adduser -S appuser -G appgroup
<span class="kw">USER</span> appuser

<span class="kw">COPY</span> --from=builder /app/target/*.jar app.jar
<span class="kw">EXPOSE</span> 8080
<span class="kw">ENTRYPOINT</span> [<span class="str">"java"</span>, <span class="str">"-jar"</span>, <span class="str">"app.jar"</span>]</code></pre>
          </code-block>
          <h4 id="tema-15-microservicios">15.5 Comunicación en Arquitecturas de Microservicios: Síncrona vs Asíncrona</h4>
          <p>
            Al modularizar BiblioTech en un ecosistema de microservicios (Catálogo, Préstamos, Notificaciones y Estadísticas), la estrategia de integración determina la disponibilidad, tolerancia a fallos y acoplamiento:
          </p>
          <table>
            <thead>
              <tr>
                <th>Criterio</th>
                <th>Comunicación Síncrona (REST / OpenFeign)</th>
                <th>Comunicación Asíncrona (Event-Driven con Kafka / RabbitMQ)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><strong>Paradigma</strong></td>
                <td>Petición / Respuesta bloqueante sobre HTTP.</td>
                <td>Basado en eventos (Event-Driven) con topics Pub/Sub.</td>
              </tr>
              <tr>
                <td><strong>Tecnologías Spring</strong></td>
                <td><code class="kw">RestClient</code>, <code class="kw">WebClient</code>, <code class="kw">@FeignClient</code>.</td>
                <td><code class="kw">Spring for Apache Kafka</code> (<code class="kw">KafkaTemplate</code>, <code class="kw">@KafkaListener</code>), <code class="kw">Spring AMQP</code>.</td>
              </tr>
              <tr>
                <td><strong>Acoplamiento Temporal</strong></td>
                <td>Alto: Emisor y receptor deben estar disponibles en el instante.</td>
                <td>Nulo: El emisor publica el evento en el broker y prosigue sin bloquearse.</td>
              </tr>
              <tr>
                <td><strong>Resiliencia a Caídas</strong></td>
                <td>Riesgo de cascada; exige Circuit Breaker (Resilience4j).</td>
                <td>Alta: Los mensajes permanecen retenidos en el topic hasta la recuperación del consumidor.</td>
              </tr>
              <tr>
                <td><strong>Casos de Uso Típicos</strong></td>
                <td>Consulta puntual de disponibilidad de un libro en tiempo real.</td>
                <td>Publicación de <code class="kw">LibroPrestadoEvent</code> para envío de emails de confirmación y actualización de estadísticas.</td>
              </tr>
            </tbody>
          </table>

          <code-block lang="java">
<pre><code><span class="kw">package</span> com.bibliotech.event;

<span class="kw">import</span> org.springframework.kafka.core.<span class="typ">KafkaTemplate</span>;
<span class="kw">import</span> org.springframework.stereotype.<span class="typ">Service</span>;
<span class="kw">import</span> java.time.<span class="typ">Instant</span>;

<span class="cmt">// 1. Evento inmutable de dominio emitido por BiblioTech</span>
<span class="kw">public record</span> <span class="typ">LibroPrestadoEvent</span>(
    <span class="typ">Long</span> prestamoId,
    <span class="typ">Long</span> libroId,
    <span class="typ">Long</span> usuarioId,
    <span class="typ">Instant</span> fechaPrestamo
) {}

<span class="cmt">// 2. Productor de eventos asíncrono sobre Apache Kafka</span>
<span class="ann">@Service</span>
<span class="kw">public class</span> <span class="typ">PrestamoEventPublisher</span> {

    <span class="kw">private final</span> <span class="typ">KafkaTemplate</span>&lt;<span class="typ">String</span>, <span class="typ">LibroPrestadoEvent</span>&gt; kafkaTemplate;

    <span class="kw">public</span> <span class="fn">PrestamoEventPublisher</span>(<span class="typ">KafkaTemplate</span>&lt;<span class="typ">String</span>, <span class="typ">LibroPrestadoEvent</span>&gt; kafkaTemplate) {
        <span class="kw">this</span>.kafkaTemplate = kafkaTemplate;
    }

    <span class="kw">public void</span> <span class="fn">publicarEventoPrestamo</span>(<span class="typ">LibroPrestadoEvent</span> evento) {
        <span class="cmt">// Publica en el topic 'bibliotech-prestamos' sin bloquear la respuesta al usuario</span>
        kafkaTemplate.<span class="fn">send</span>(<span class="str">"bibliotech-prestamos"</span>, <span class="typ">String</span>.<span class="fn">valueOf</span>(evento.<span class="fn">libroId</span>()), evento);
    }
}</code></pre>
          </code-block>

          <h4 id="tema-15-monitoreo">15.6 Monitoreo y Gestión del Rendimiento (Actuator)</h4>
          <p>
            Una aplicación empresarial no termina en el despliegue. El monitoreo continuo permite identificar cuellos de botella, fugas de memoria y errores en tiempo real utilizando <strong>Spring Boot Actuator</strong>.
          </p>
          <div class="tip-box" style="background: var(--color-canvas-subtle); border-left: 4px solid var(--color-accent); padding: 16px 20px; margin: 20px 0; border-radius: 6px;">
            <h5 style="margin-top: 0; margin-bottom: 8px; font-size: 15px; color: var(--color-fg-default);">📈 Puntos de Control (Endpoints de Actuator)</h5>
            <ul style="font-size: 13.5px; line-height: 1.6;">
              <li><code class="kw">/actuator/health</code>: Estado de salud de la app y sus dependencias (DB, Kafka).</li>
              <li><code class="kw">/actuator/metrics</code>: Métricas de JVM, memoria, CPU y tiempo de respuesta.</li>
              <li><code class="kw">/actuator/loggers</code>: Permite cambiar el nivel de log (INFO &rarr; DEBUG) en caliente sin reiniciar la aplicación.</li>
            </ul>
          </div>
        </article>
        </article>

<?php if ($is_standalone): ?>
        </div>
      </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
<?php endif; ?>
