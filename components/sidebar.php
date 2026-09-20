<?php require_once __DIR__ . '/base-url.php';

$current_script = basename($_SERVER['SCRIPT_FILENAME'] ?? 'index.php');
$current_script_path = $_SERVER['SCRIPT_NAME'] ?? '';
$request_path = str_replace('\\', '/', $_SERVER['REQUEST_URI'] ?? $_SERVER['SCRIPT_NAME'] ?? '');
$request_path = preg_replace('/\?.*$/', '', $request_path);
$request_path = trim($request_path, '/');
$clean_web_root = trim($web_root ?? '', '/');
if (!empty($clean_web_root) && strpos($request_path, $clean_web_root) === 0) {
  $request_path = trim(substr($request_path, strlen($clean_web_root)), '/');
}
$uri_segments = array_values(array_filter(explode('/', $request_path), fn($part) => $part !== ''));
$current_slug = !empty($uri_segments) ? end($uri_segments) : preg_replace('/\.php$/i', '', $current_script);

$fundamentos_topics = [
  ['label' => '1. Arq. Web + HTTP', 'href' => 'temas/arquitectura-web-http.php'],
  ['label' => '2. JSON + Jackson', 'href' => 'temas/json-jackson.php'],
  ['label' => '3. Maven + Lombok', 'href' => 'temas/maven-lombok.php'],
  ['label' => '4. Core Spring (IoC/DI)', 'href' => 'temas/core-spring-ioc.php'],
  ['label' => '5. Eventos & AOP', 'href' => 'temas/eventos-aop.php'],
];

$core_topics = [
  ['label' => '6. SOLID + Capas', 'href' => 'temas/solid-capas.php'],
  ['label' => '7. REST + ResponseEntity', 'href' => 'temas/rest-responseentity.php'],
  ['label' => '8. Servicios + DI', 'href' => 'temas/servicios-di.php'],
  ['label' => '9. Excepciones & RFC 7807', 'href' => 'temas/excepciones-problemdetail.php'],
  ['label' => '10. Hibernate & ORM', 'href' => 'temas/hibernate-orm.php'],
];

$persistencia_topics = [
  ['label' => '11. Asociaciones & Consultas', 'href' => 'temas/asociaciones-consultas.php'],
  ['label' => '12. DTOs & Repositorios', 'href' => 'temas/dtos-repositorios.php'],
  ['label' => '13. MapStruct & Specifications', 'href' => 'temas/mapstruct-specifications.php'],
];

$calidad_topics = [
  ['label' => '14. Validaciones & Errores', 'href' => 'temas/validaciones-errores.php'],
  ['label' => '15. Logs, Perfiles, Swagger', 'href' => 'temas/logs-perfiles-swagger.php'],
  ['label' => '16. Actuator & Observabilidad', 'href' => 'temas/actuator-observabilidad.php'],
];

$testing_topics = [
  ['label' => '17. JUnit 5 & Mockito', 'href' => 'temas/junit5-mockito.php'],
  ['label' => '18. Spring Boot Test', 'href' => 'temas/spring-boot-test.php'],
  ['label' => '19. Testcontainers & WireMock', 'href' => 'temas/testcontainers-wiremock.php'],
];

$seguridad_topics = [
  ['label' => '20. JWT + Docker', 'href' => 'temas/jwt-docker.php'],
  ['label' => '21. OAuth2 & Security 6', 'href' => 'temas/oauth2-security.php'],
];

$theme_block_map = [
  'arquitectura-web-http.php' => ['block_label' => '📦 1. Fundamentos', 'route' => 'bloques/fundamentos.php', 'topics' => $fundamentos_topics],
  'json-jackson.php' => ['block_label' => '📦 1. Fundamentos', 'route' => 'bloques/fundamentos.php', 'topics' => $fundamentos_topics],
  'maven-lombok.php' => ['block_label' => '📦 1. Fundamentos', 'route' => 'bloques/fundamentos.php', 'topics' => $fundamentos_topics],
  'core-spring-ioc.php' => ['block_label' => '📦 1. Fundamentos', 'route' => 'bloques/fundamentos.php', 'topics' => $fundamentos_topics],
  'eventos-aop.php' => ['block_label' => '📦 1. Fundamentos', 'route' => 'bloques/fundamentos.php', 'topics' => $fundamentos_topics],

  'solid-capas.php' => ['block_label' => '📦 2. Core Spring Boot', 'route' => 'bloques/core-spring-boot.php', 'topics' => $core_topics],
  'rest-responseentity.php' => ['block_label' => '📦 2. Core Spring Boot', 'route' => 'bloques/core-spring-boot.php', 'topics' => $core_topics],
  'servicios-di.php' => ['block_label' => '📦 2. Core Spring Boot', 'route' => 'bloques/core-spring-boot.php', 'topics' => $core_topics],
  'excepciones-problemdetail.php' => ['block_label' => '📦 2. Core Spring Boot', 'route' => 'bloques/core-spring-boot.php', 'topics' => $core_topics],
  'hibernate-orm.php' => ['block_label' => '📦 2. Core Spring Boot', 'route' => 'bloques/core-spring-boot.php', 'topics' => $core_topics],

  'asociaciones-consultas.php' => ['block_label' => '📦 3. Persistencia & DTOs', 'route' => 'bloques/persistencia-dtos.php', 'topics' => $persistencia_topics],
  'dtos-repositorios.php' => ['block_label' => '📦 3. Persistencia & DTOs', 'route' => 'bloques/persistencia-dtos.php', 'topics' => $persistencia_topics],
  'mapstruct-specifications.php' => ['block_label' => '📦 3. Persistencia & DTOs', 'route' => 'bloques/persistencia-dtos.php', 'topics' => $persistencia_topics],

  'validaciones-errores.php' => ['block_label' => '📦 4. Calidad & Ops', 'route' => 'bloques/calidad-ops.php', 'topics' => $calidad_topics],
  'logs-perfiles-swagger.php' => ['block_label' => '📦 4. Calidad & Ops', 'route' => 'bloques/calidad-ops.php', 'topics' => $calidad_topics],
  'actuator-observabilidad.php' => ['block_label' => '📦 4. Calidad & Ops', 'route' => 'bloques/calidad-ops.php', 'topics' => $calidad_topics],

  'junit5-mockito.php' => ['block_label' => '📦 5. Testing', 'route' => 'bloques/testing.php', 'topics' => $testing_topics],
  'spring-boot-test.php' => ['block_label' => '📦 5. Testing', 'route' => 'bloques/testing.php', 'topics' => $testing_topics],
  'testcontainers-wiremock.php' => ['block_label' => '📦 5. Testing', 'route' => 'bloques/testing.php', 'topics' => $testing_topics],

  'jwt-docker.php' => ['block_label' => '📦 6. Seguridad & Docker', 'route' => 'bloques/seguridad-docker.php', 'topics' => $seguridad_topics],
  'oauth2-security.php' => ['block_label' => '📦 6. Seguridad & Docker', 'route' => 'bloques/seguridad-docker.php', 'topics' => $seguridad_topics],
];

$is_topic_page = false;
$current_block = null;

$normalized_current_script = preg_replace('/\.php$/i', '', $current_script);
if (array_key_exists($current_script, $theme_block_map) || array_key_exists($normalized_current_script, $theme_block_map)) {
  $is_topic_page = true;
  $current_block = $theme_block_map[$current_script] ?? $theme_block_map[$normalized_current_script] ?? null;
}

if (!$current_block) {
  foreach ($theme_block_map as $file => $data) {
    $normalized_file = preg_replace('/\.php$/i', '', $file);
    if ($normalized_file === $current_slug || $current_slug === $file || $current_slug === $normalized_file) {
      $current_block = $data;
      $is_topic_page = true;
      break;
    }

    if (count($uri_segments) > 1 && $uri_segments[count($uri_segments) - 2] === $normalized_file) {
      $current_block = $data;
      $is_topic_page = true;
      break;
    }
  }
}
?>
    <aside class="sidebar">
      <div class="sidebar-section-title">Contenido Principal</div>
      <ul class="sidebar-nav">
        <li><a href="<?php echo $base_url; ?>index" class="sidebar-link"><span>🏠 Home</span></a></li>
        <li><a href="<?php echo $base_url; ?>ruta" class="sidebar-link"><span>🗺️ Ruta de Aprendizaje</span></a></li>
        <li><a href="<?php echo $base_url; ?>caso-estudio" class="sidebar-link"><span>📚 Caso Práctico BiblioTech</span></a></li>
        <li><a href="<?php echo $base_url; ?>filosofia" class="sidebar-link"><span>🏛️ Filosofía y Paradigma</span></a></li>
      </ul>

      <div class="sidebar-section-title">Secciones de Contenido</div>
      <ul class="sidebar-nav">
        <li>
          <a href="<?php echo $base_url; ?>fundamentos" class="sidebar-link <?php echo ($current_slug === 'fundamentos' || (isset($current_block['route']) && $current_block['route'] === 'bloques/fundamentos.php')) ? 'parent-active' : ''; ?>"><span>📦 1. Fundamentos</span></a>
          <ul class="sidebar-subnav">
            <li><a href="<?php echo $base_url; ?>fundamentos/arquitectura-web-http" class="<?php echo $current_slug === 'arquitectura-web-http' ? 'active' : ''; ?>">1. Arq. Web + HTTP</a></li>
            <li><a href="<?php echo $base_url; ?>fundamentos/json-jackson" class="<?php echo $current_slug === 'json-jackson' ? 'active' : ''; ?>">2. JSON + Jackson</a></li>
            <li><a href="<?php echo $base_url; ?>fundamentos/maven-lombok" class="<?php echo $current_slug === 'maven-lombok' ? 'active' : ''; ?>">3. Maven + Lombok</a></li>
            <li><a href="<?php echo $base_url; ?>fundamentos/core-spring-ioc" class="<?php echo $current_slug === 'core-spring-ioc' ? 'active' : ''; ?>">4. Core Spring (IoC/DI)</a></li>
            <li><a href="<?php echo $base_url; ?>fundamentos/eventos-aop" class="<?php echo $current_slug === 'eventos-aop' ? 'active' : ''; ?>">5. Eventos & AOP</a></li>
          </ul>
        </li>
        <li>
          <a href="<?php echo $base_url; ?>core-spring-boot" class="sidebar-link <?php echo ($current_slug === 'core-spring-boot' || (isset($current_block['route']) && $current_block['route'] === 'bloques/core-spring-boot.php')) ? 'parent-active' : ''; ?>"><span>📦 2. Core Spring Boot</span></a>
          <ul class="sidebar-subnav">
            <li><a href="<?php echo $base_url; ?>core-spring-boot/solid-capas" class="<?php echo $current_slug === 'solid-capas' ? 'active' : ''; ?>">6. SOLID + Capas</a></li>
            <li><a href="<?php echo $base_url; ?>core-spring-boot/rest-responseentity" class="<?php echo $current_slug === 'rest-responseentity' ? 'active' : ''; ?>">7. REST + ResponseEntity</a></li>
            <li><a href="<?php echo $base_url; ?>core-spring-boot/servicios-di" class="<?php echo $current_slug === 'servicios-di' ? 'active' : ''; ?>">8. Servicios + DI</a></li>
            <li><a href="<?php echo $base_url; ?>core-spring-boot/excepciones-problemdetail" class="<?php echo $current_slug === 'excepciones-problemdetail' ? 'active' : ''; ?>">9. Excepciones & RFC 7807</a></li>
            <li><a href="<?php echo $base_url; ?>core-spring-boot/hibernate-orm" class="<?php echo $current_slug === 'hibernate-orm' ? 'active' : ''; ?>">10. Hibernate & ORM</a></li>
          </ul>
        </li>
        <li>
          <a href="<?php echo $base_url; ?>persistencia-dtos" class="sidebar-link <?php echo ($current_slug === 'persistencia-dtos' || (isset($current_block['route']) && $current_block['route'] === 'bloques/persistencia-dtos.php')) ? 'parent-active' : ''; ?>"><span>📦 3. Persistencia & DTOs</span></a>
          <ul class="sidebar-subnav">
            <li><a href="<?php echo $base_url; ?>persistencia-dtos/asociaciones-consultas" class="<?php echo $current_slug === 'asociaciones-consultas' ? 'active' : ''; ?>">11. Asociaciones & Consultas</a></li>
            <li><a href="<?php echo $base_url; ?>persistencia-dtos/dtos-repositorios" class="<?php echo $current_slug === 'dtos-repositorios' ? 'active' : ''; ?>">12. DTOs & Repositorios</a></li>
            <li><a href="<?php echo $base_url; ?>persistencia-dtos/mapstruct-specifications" class="<?php echo $current_slug === 'mapstruct-specifications' ? 'active' : ''; ?>">13. MapStruct & Specifications</a></li>
          </ul>
        </li>
        <li>
          <a href="<?php echo $base_url; ?>calidad-ops" class="sidebar-link <?php echo ($current_slug === 'calidad-ops' || (isset($current_block['route']) && $current_block['route'] === 'bloques/calidad-ops.php')) ? 'parent-active' : ''; ?>"><span>📦 4. Calidad & Ops</span></a>
          <ul class="sidebar-subnav">
            <li><a href="<?php echo $base_url; ?>calidad-ops/validaciones-errores" class="<?php echo $current_slug === 'validaciones-errores' ? 'active' : ''; ?>">14. Validaciones & Errores</a></li>
            <li><a href="<?php echo $base_url; ?>calidad-ops/logs-perfiles-swagger" class="<?php echo $current_slug === 'logs-perfiles-swagger' ? 'active' : ''; ?>">15. Logs, Perfiles, Swagger</a></li>
            <li><a href="<?php echo $base_url; ?>calidad-ops/actuator-observabilidad" class="<?php echo $current_slug === 'actuator-observabilidad' ? 'active' : ''; ?>">16. Actuator & Observabilidad</a></li>
          </ul>
        </li>
        <li>
          <a href="<?php echo $base_url; ?>testing" class="sidebar-link <?php echo ($current_slug === 'testing' || (isset($current_block['route']) && $current_block['route'] === 'bloques/testing.php')) ? 'parent-active' : ''; ?>"><span>📦 5. Testing</span></a>
          <ul class="sidebar-subnav">
            <li><a href="<?php echo $base_url; ?>testing/junit5-mockito" class="<?php echo $current_slug === 'junit5-mockito' ? 'active' : ''; ?>">17. JUnit 5 & Mockito</a></li>
            <li><a href="<?php echo $base_url; ?>testing/spring-boot-test" class="<?php echo $current_slug === 'spring-boot-test' ? 'active' : ''; ?>">18. Spring Boot Test</a></li>
            <li><a href="<?php echo $base_url; ?>testing/testcontainers-wiremock" class="<?php echo $current_slug === 'testcontainers-wiremock' ? 'active' : ''; ?>">19. Testcontainers & WireMock</a></li>
          </ul>
        </li>
        <li>
          <a href="<?php echo $base_url; ?>seguridad-docker" class="sidebar-link <?php echo ($current_slug === 'seguridad-docker' || (isset($current_block['route']) && $current_block['route'] === 'bloques/seguridad-docker.php')) ? 'parent-active' : ''; ?>"><span>📦 6. Seguridad & Docker</span></a>
          <ul class="sidebar-subnav">
            <li><a href="<?php echo $base_url; ?>seguridad-docker/jwt-docker" class="<?php echo $current_slug === 'jwt-docker' ? 'active' : ''; ?>">20. JWT + Docker</a></li>
            <li><a href="<?php echo $base_url; ?>seguridad-docker/oauth2-security" class="<?php echo $current_slug === 'oauth2-security' ? 'active' : ''; ?>">21. OAuth2 & Security 6</a></li>
          </ul>
        </li>
      </ul>

      <div class="sidebar-section-title">Evaluación y Recursos</div>
      <ul class="sidebar-nav">
        <li><a href="<?php echo $base_url; ?>primeros-pasos" class="sidebar-link <?php echo ($current_slug === 'primeros-pasos') ? 'parent-active' : ''; ?>"><span>🛠️ Instalación y Primeros Pasos</span></a></li>
        <li><a href="<?php echo $base_url; ?>recursos" class="sidebar-link <?php echo ($current_slug === 'recursos') ? 'parent-active' : ''; ?>"><span>🎓 Credenciales y Recursos Oficiales</span></a></li>
        <li><a href="<?php echo $base_url; ?>proyectos" class="sidebar-link <?php echo ($current_slug === 'proyectos') ? 'parent-active' : ''; ?>"><span>🚀 Proyectos Prácticos</span></a></li>
        <li style="margin-top: 10px; border-top: 1px solid var(--color-border-muted); padding-top: 8px;">
          <button class="sidebar-link theme-toggle-trigger" style="width: 100%; background: none; border: none; cursor: pointer; text-align: left; font-family: inherit;">
            <span>☀️ Modo Diurno</span>
          </button>
        </li>
      </ul>
    </aside>
