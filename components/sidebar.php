<?php require_once __DIR__ . '/base-url.php';

$current_script = basename($_SERVER['SCRIPT_FILENAME'] ?? 'index.php');
$current_script_path = $_SERVER['SCRIPT_NAME'] ?? '';
$request_path = str_replace('\\', '/', $_SERVER['REQUEST_URI'] ?? $_SERVER['SCRIPT_NAME'] ?? '');
$request_path = preg_replace('/\?.*$/', '', $request_path);
$request_path = trim($request_path, '/');
if (strpos($request_path, 'guia-estudio') !== false) {
  $pos = strpos($request_path, 'guia-estudio');
  $request_path = substr($request_path, $pos + strlen('guia-estudio'));
  $request_path = trim($request_path, '/');
}
$uri_segments = array_values(array_filter(explode('/', $request_path), fn($part) => $part !== ''));
$current_slug = !empty($uri_segments) ? end($uri_segments) : preg_replace('/\.php$/i', '', $current_script);
$theme_block_map = [
  'arquitectura-web-http.php' => [
    'block_label' => '📦 1. Fundamentos',
    'route' => 'bloques/fundamentos.php',
    'topics' => [
      ['label' => '1. Arq. Web + HTTP', 'href' => 'temas/arquitectura-web-http.php'],
      ['label' => '2. JSON + Jackson', 'href' => 'temas/json-jackson.php'],
      ['label' => '3. Maven + Lombok', 'href' => 'temas/maven-lombok.php'],
      ['label' => '4. Core Spring (IoC/DI)', 'href' => 'temas/core-spring-ioc.php'],
    ],
  ],
  'json-jackson.php' => [
    'block_label' => '📦 1. Fundamentos',
    'route' => 'bloques/fundamentos.php',
    'topics' => [
      ['label' => '1. Arq. Web + HTTP', 'href' => 'temas/arquitectura-web-http.php'],
      ['label' => '2. JSON + Jackson', 'href' => 'temas/json-jackson.php'],
      ['label' => '3. Maven + Lombok', 'href' => 'temas/maven-lombok.php'],
      ['label' => '4. Core Spring (IoC/DI)', 'href' => 'temas/core-spring-ioc.php'],
    ],
  ],
  'maven-lombok.php' => [
    'block_label' => '📦 1. Fundamentos',
    'route' => 'bloques/fundamentos.php',
    'topics' => [
      ['label' => '1. Arq. Web + HTTP', 'href' => 'temas/arquitectura-web-http.php'],
      ['label' => '2. JSON + Jackson', 'href' => 'temas/json-jackson.php'],
      ['label' => '3. Maven + Lombok', 'href' => 'temas/maven-lombok.php'],
      ['label' => '4. Core Spring (IoC/DI)', 'href' => 'temas/core-spring-ioc.php'],
    ],
  ],
  'core-spring-ioc.php' => [
    'block_label' => '📦 1. Fundamentos',
    'route' => 'bloques/fundamentos.php',
    'topics' => [
      ['label' => '1. Arq. Web + HTTP', 'href' => 'temas/arquitectura-web-http.php'],
      ['label' => '2. JSON + Jackson', 'href' => 'temas/json-jackson.php'],
      ['label' => '3. Maven + Lombok', 'href' => 'temas/maven-lombok.php'],
      ['label' => '4. Core Spring (IoC/DI)', 'href' => 'temas/core-spring-ioc.php'],
    ],
  ],
  'solid-capas.php' => [
    'block_label' => '📦 2. Core Spring Boot',
    'route' => 'bloques/core-spring-boot.php',
    'topics' => [
      ['label' => '5. SOLID + Capas', 'href' => 'temas/solid-capas.php'],
      ['label' => '6. REST + ResponseEntity', 'href' => 'temas/rest-responseentity.php'],
      ['label' => '7. Servicios + DI', 'href' => 'temas/servicios-di.php'],
      ['label' => '8. Hibernate & ORM', 'href' => 'temas/hibernate-orm.php'],
    ],
  ],
  'rest-responseentity.php' => [
    'block_label' => '📦 2. Core Spring Boot',
    'route' => 'bloques/core-spring-boot.php',
    'topics' => [
      ['label' => '5. SOLID + Capas', 'href' => 'temas/solid-capas.php'],
      ['label' => '6. REST + ResponseEntity', 'href' => 'temas/rest-responseentity.php'],
      ['label' => '7. Servicios + DI', 'href' => 'temas/servicios-di.php'],
      ['label' => '8. Hibernate & ORM', 'href' => 'temas/hibernate-orm.php'],
    ],
  ],
  'servicios-di.php' => [
    'block_label' => '📦 2. Core Spring Boot',
    'route' => 'bloques/core-spring-boot.php',
    'topics' => [
      ['label' => '5. SOLID + Capas', 'href' => 'temas/solid-capas.php'],
      ['label' => '6. REST + ResponseEntity', 'href' => 'temas/rest-responseentity.php'],
      ['label' => '7. Servicios + DI', 'href' => 'temas/servicios-di.php'],
      ['label' => '8. Hibernate & ORM', 'href' => 'temas/hibernate-orm.php'],
    ],
  ],
  'hibernate-orm.php' => [
    'block_label' => '📦 2. Core Spring Boot',
    'route' => 'bloques/core-spring-boot.php',
    'topics' => [
      ['label' => '5. SOLID + Capas', 'href' => 'temas/solid-capas.php'],
      ['label' => '6. REST + ResponseEntity', 'href' => 'temas/rest-responseentity.php'],
      ['label' => '7. Servicios + DI', 'href' => 'temas/servicios-di.php'],
      ['label' => '8. Hibernate & ORM', 'href' => 'temas/hibernate-orm.php'],
    ],
  ],
  'asociaciones-consultas.php' => [
    'block_label' => '📦 3. Persistencia & DTOs',
    'route' => 'bloques/persistencia-dtos.php',
    'topics' => [
      ['label' => '9. Asociaciones & Consultas', 'href' => 'temas/asociaciones-consultas.php'],
      ['label' => '10. DTOs & Repositorios', 'href' => 'temas/dtos-repositorios.php'],
    ],
  ],
  'dtos-repositorios.php' => [
    'block_label' => '📦 3. Persistencia & DTOs',
    'route' => 'bloques/persistencia-dtos.php',
    'topics' => [
      ['label' => '9. Asociaciones & Consultas', 'href' => 'temas/asociaciones-consultas.php'],
      ['label' => '10. DTOs & Repositorios', 'href' => 'temas/dtos-repositorios.php'],
    ],
  ],
  'validaciones-errores.php' => [
    'block_label' => '📦 4. Calidad & Ops',
    'route' => 'bloques/calidad-ops.php',
    'topics' => [
      ['label' => '11. Validaciones & Errores', 'href' => 'temas/validaciones-errores.php'],
      ['label' => '12. Logs, Perfiles, Swagger', 'href' => 'temas/logs-perfiles-swagger.php'],
    ],
  ],
  'logs-perfiles-swagger.php' => [
    'block_label' => '📦 4. Calidad & Ops',
    'route' => 'bloques/calidad-ops.php',
    'topics' => [
      ['label' => '11. Validaciones & Errores', 'href' => 'temas/validaciones-errores.php'],
      ['label' => '12. Logs, Perfiles, Swagger', 'href' => 'temas/logs-perfiles-swagger.php'],
    ],
  ],
  'junit5-mockito.php' => [
    'block_label' => '📦 5. Testing',
    'route' => 'bloques/testing.php',
    'topics' => [
      ['label' => '13. JUnit 5 & Mockito', 'href' => 'temas/junit5-mockito.php'],
      ['label' => '14. Spring Boot Test', 'href' => 'temas/spring-boot-test.php'],
    ],
  ],
  'spring-boot-test.php' => [
    'block_label' => '📦 5. Testing',
    'route' => 'bloques/testing.php',
    'topics' => [
      ['label' => '13. JUnit 5 & Mockito', 'href' => 'temas/junit5-mockito.php'],
      ['label' => '14. Spring Boot Test', 'href' => 'temas/spring-boot-test.php'],
    ],
  ],
  'jwt-docker.php' => [
    'block_label' => '📦 6. Seguridad & Docker',
    'route' => 'bloques/seguridad-docker.php',
    'topics' => [
      ['label' => '15. JWT + Docker', 'href' => 'temas/jwt-docker.php'],
    ],
  ],
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
          </ul>
        </li>
        <li>
          <a href="<?php echo $base_url; ?>core-spring-boot" class="sidebar-link <?php echo ($current_slug === 'core-spring-boot' || (isset($current_block['route']) && $current_block['route'] === 'bloques/core-spring-boot.php')) ? 'parent-active' : ''; ?>"><span>📦 2. Core Spring Boot</span></a>
          <ul class="sidebar-subnav">
            <li><a href="<?php echo $base_url; ?>core-spring-boot/solid-capas" class="<?php echo $current_slug === 'solid-capas' ? 'active' : ''; ?>">5. SOLID + Capas</a></li>
            <li><a href="<?php echo $base_url; ?>core-spring-boot/rest-responseentity" class="<?php echo $current_slug === 'rest-responseentity' ? 'active' : ''; ?>">6. REST + ResponseEntity</a></li>
            <li><a href="<?php echo $base_url; ?>core-spring-boot/servicios-di" class="<?php echo $current_slug === 'servicios-di' ? 'active' : ''; ?>">7. Servicios + DI</a></li>
            <li><a href="<?php echo $base_url; ?>core-spring-boot/hibernate-orm" class="<?php echo $current_slug === 'hibernate-orm' ? 'active' : ''; ?>">8. Hibernate & ORM</a></li>
          </ul>
        </li>
        <li>
          <a href="<?php echo $base_url; ?>persistencia-dtos" class="sidebar-link <?php echo ($current_slug === 'persistencia-dtos' || (isset($current_block['route']) && $current_block['route'] === 'bloques/persistencia-dtos.php')) ? 'parent-active' : ''; ?>"><span>📦 3. Persistencia & DTOs</span></a>
          <ul class="sidebar-subnav">
            <li><a href="<?php echo $base_url; ?>persistencia-dtos/asociaciones-consultas" class="<?php echo $current_slug === 'asociaciones-consultas' ? 'active' : ''; ?>">9. Asociaciones & Consultas</a></li>
            <li><a href="<?php echo $base_url; ?>persistencia-dtos/dtos-repositorios" class="<?php echo $current_slug === 'dtos-repositorios' ? 'active' : ''; ?>">10. DTOs & Repositorios</a></li>
          </ul>
        </li>
        <li>
          <a href="<?php echo $base_url; ?>calidad-ops" class="sidebar-link <?php echo ($current_slug === 'calidad-ops' || (isset($current_block['route']) && $current_block['route'] === 'bloques/calidad-ops.php')) ? 'parent-active' : ''; ?>"><span>📦 4. Calidad & Ops</span></a>
          <ul class="sidebar-subnav">
            <li><a href="<?php echo $base_url; ?>calidad-ops/validaciones-errores" class="<?php echo $current_slug === 'validaciones-errores' ? 'active' : ''; ?>">11. Validaciones & Errores</a></li>
            <li><a href="<?php echo $base_url; ?>calidad-ops/logs-perfiles-swagger" class="<?php echo $current_slug === 'logs-perfiles-swagger' ? 'active' : ''; ?>">12. Logs, Perfiles, Swagger</a></li>
          </ul>
        </li>
        <li>
          <a href="<?php echo $base_url; ?>testing" class="sidebar-link <?php echo ($current_slug === 'testing' || (isset($current_block['route']) && $current_block['route'] === 'bloques/testing.php')) ? 'parent-active' : ''; ?>"><span>📦 5. Testing</span></a>
          <ul class="sidebar-subnav">
            <li><a href="<?php echo $base_url; ?>testing/junit5-mockito" class="<?php echo $current_slug === 'junit5-mockito' ? 'active' : ''; ?>">13. JUnit 5 & Mockito</a></li>
            <li><a href="<?php echo $base_url; ?>testing/spring-boot-test" class="<?php echo $current_slug === 'spring-boot-test' ? 'active' : ''; ?>">14. Spring Boot Test</a></li>
          </ul>
        </li>
        <li>
          <a href="<?php echo $base_url; ?>seguridad-docker" class="sidebar-link <?php echo ($current_slug === 'seguridad-docker' || (isset($current_block['route']) && $current_block['route'] === 'bloques/seguridad-docker.php')) ? 'parent-active' : ''; ?>"><span>📦 6. Seguridad & Docker</span></a>
          <ul class="sidebar-subnav">
            <li><a href="<?php echo $base_url; ?>seguridad-docker/jwt-docker" class="<?php echo $current_slug === 'jwt-docker' ? 'active' : ''; ?>">15. JWT + Docker</a></li>
          </ul>
        </li>
      </ul>

      <div class="sidebar-section-title">Evaluación y Recursos</div>
      <ul class="sidebar-nav">
        <li><a href="<?php echo $base_url; ?>index" class="sidebar-link"><span>🎯 Cuaderno Principal</span></a></li>
        <li><a href="<?php echo $base_url; ?>recursos" class="sidebar-link"><span>📘 Diccionario y Resúmenes</span></a></li>
        <li style="margin-top: 10px; border-top: 1px solid var(--color-border-muted); padding-top: 8px;">
          <button class="sidebar-link theme-toggle-trigger" style="width: 100%; background: none; border: none; cursor: pointer; text-align: left; font-family: inherit;">
            <span>☀️ Modo Diurno</span>
          </button>
        </li>
      </ul>
    </aside>
