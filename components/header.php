<?php require_once __DIR__ . '/base-url.php'; ?>
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
      <div class="search-wrapper">
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
    $current_script = basename($_SERVER['SCRIPT_FILENAME'] ?? 'index.php');
    $breadcrumb_map = [
      'index.php' => 'Inicio',
      'core-spring-boot.php' => 'Bloque 2',
      'fundamentos.php' => 'Bloque 1',
      'persistencia-dtos.php' => 'Bloque 3',
      'testing.php' => 'Bloque 5',
      'seguridad-docker.php' => 'Bloque 6',
      'calidad-ops.php' => 'Bloque 4',
      'filosofia.php' => 'Filosofía',
      'caso-estudio.php' => 'Caso práctico',
      'ruta.php' => 'Ruta de aprendizaje',
    ];
    $page_breadcrumb = $breadcrumb_map[$current_script] ?? 'Contenido';
  ?>

  <nav class="page-breadcrumbs" aria-label="Breadcrumb">
    <a href="<?php echo $base_url; ?>index">Inicio</a>
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-current"><?php echo htmlspecialchars($page_breadcrumb); ?></span>
  </nav>

  <div class="layout-container">
