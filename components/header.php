<?php
  require_once __DIR__ . '/base-url.php';
  $request_path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? '/';
  $clean_path = trim(str_replace($web_root, '', $request_path), '/');
  $is_home_page = ($clean_path === '' || $clean_path === 'index' || $clean_path === 'index.php');
?>
<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Guía de Estudio — Spring Boot, Arquitectura y Ecosistema Java</title>
  <link rel="stylesheet" href="<?php echo $base_url; ?>css/github-markdown.css">
  <link rel="stylesheet" href="<?php echo $base_url; ?>css/main.css">
  <script>window.BASE_URL = "<?php echo $base_url; ?>";</script>
</head>
<body>
  <!-- Top Reading Progress Indicator Line -->
  <div id="scroll-progress-line" class="scroll-progress-line"></div>

  <!-- Top Repository Navigation Bar -->
  <header class="top-nav">
    <div class="nav-brand">
      <button id="mobile-toggle" class="mobile-toggle" aria-label="Abrir menú">☰</button>
      <span style="font-size: 18px;">☕</span>
      <span class="repo-link" style="font-weight: 700;">Java | Spring Boot | Introducción</span>
    </div>

    <div class="nav-controls">
      <div class="search-wrapper"<?php if ($is_home_page) echo ' style="display: none !important;"'; ?>>
        <span class="search-icon">🔍</span>
        <input type="text" id="search-input" class="search-input" placeholder="Buscar palabras clave, @anotaciones, temas... (Ctrl+K)" autocomplete="off" spellcheck="false" role="combobox" aria-expanded="false" aria-controls="search-autocomplete-dropdown" aria-label="Buscar en el manual">
        <div id="search-autocomplete-dropdown" class="search-autocomplete-dropdown" style="display: none;"></div>
      </div>

      <div class="progress-indicator" title="Progreso de lectura de la página">
        <span>Lectura:</span>
        <div class="progress-bar-mini">
          <div id="progress-fill" class="progress-fill"></div>
        </div>
        <span id="progress-text">0%</span>
      </div>

      <button id="theme-toggle-btn" class="theme-toggle-btn theme-toggle-trigger">☀️ Modo Diurno</button>
    </div>
  </header>

  <?php
    $current_script = $current_script ?? basename($_SERVER['SCRIPT_FILENAME'] ?? 'index.php');
    $breadcrumb_map = [
      'index.php' => 'Inicio',
      'fundamentos.php' => 'Bloque 1: Fundamentos',
      'core-spring-boot.php' => 'Bloque 2: Core Spring Boot',
      'persistencia-dtos.php' => 'Bloque 3: Persistencia & DTOs',
      'calidad-ops.php' => 'Bloque 4: Calidad & Ops',
      'testing.php' => 'Bloque 5: Testing',
      'seguridad-docker.php' => 'Bloque 6: Seguridad & Docker',
      'filosofia.php' => 'Filosofía y Paradigma',
      'caso-estudio.php' => 'Caso práctico BiblioTech',
      'ruta.php' => 'Ruta de aprendizaje',
      'primeros-pasos.php' => 'Instalación y Primeros Pasos',
      'recursos.php' => 'Credenciales y Recursos Oficiales',
      'proyectos.php' => 'Proyectos Prácticos',
      'arquitectura-web-http.php' => '1. Arq. Web + HTTP',
      'json-jackson.php' => '2. JSON + Jackson',
      'maven-lombok.php' => '3. Maven + Lombok',
      'core-spring-ioc.php' => '4. Core Spring (IoC/DI)',
      'eventos-aop.php' => '5. Eventos & AOP',
      'solid-capas.php' => '6. SOLID + Capas',
      'rest-responseentity.php' => '7. REST + ResponseEntity',
      'servicios-di.php' => '8. Servicios + DI',
      'excepciones-problemdetail.php' => '9. Excepciones & RFC 7807',
      'hibernate-orm.php' => '10. Hibernate & ORM',
      'asociaciones-consultas.php' => '11. Asociaciones & Consultas',
      'dtos-repositorios.php' => '12. DTOs & Repositorios',
      'mapstruct-specifications.php' => '13. MapStruct & Specifications',
      'validaciones-errores.php' => '14. Validaciones & Errores',
      'logs-perfiles-swagger.php' => '15. Logs, Perfiles, Swagger',
      'actuator-observabilidad.php' => '16. Actuator & Observabilidad',
      'junit5-mockito.php' => '17. JUnit 5 & Mockito',
      'spring-boot-test.php' => '18. Spring Boot Test',
      'testcontainers-wiremock.php' => '19. Testcontainers & WireMock',
      'jwt-docker.php' => '20. JWT + Docker',
      'oauth2-security.php' => '21. OAuth2 & Security 6',
    ];
    $page_breadcrumb = $breadcrumb_map[$current_script] ?? 'Contenido';
  ?>

  <nav class="page-breadcrumbs" aria-label="Breadcrumb">
    <?php if ($is_home_page): ?>
      <span class="breadcrumb-current">Inicio</span>
    <?php else: ?>
      <a href="<?php echo $base_url; ?>index">Inicio</a>
      <span class="breadcrumb-separator">/</span>
      <span class="breadcrumb-current"><?php echo htmlspecialchars($page_breadcrumb); ?></span>
    <?php endif; ?>
  </nav>

  <div class="layout-container">
