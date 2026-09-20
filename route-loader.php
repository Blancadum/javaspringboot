<?php

$projectRoot = rtrim(str_replace('\\', '/', __DIR__), '/');
$currentScript = $_SERVER['SCRIPT_FILENAME'] ?? __FILE__;
$currentDir = rtrim(str_replace('\\', '/', dirname($currentScript)), '/');
$relativeDir = trim(str_replace($projectRoot, '', $currentDir), '/');

$aliasMap = [
  'fundamentos' => 'bloques/fundamentos.php',
  'core-spring-boot' => 'bloques/core-spring-boot.php',
  'persistencia-dtos' => 'bloques/persistencia-dtos.php',
  'calidad-ops' => 'bloques/calidad-ops.php',
  'testing' => 'bloques/testing.php',
  'seguridad-docker' => 'bloques/seguridad-docker.php',
  'ruta' => 'ruta.php',
  'caso-estudio' => 'caso-estudio.php',
  'filosofia' => 'filosofia.php',
  'recursos' => 'recursos.php',
  'index' => 'index.php',

  'fundamentos/arquitectura-web-http' => 'temas/arquitectura-web-http.php',
  'fundamentos/json-jackson' => 'temas/json-jackson.php',
  'fundamentos/maven-lombok' => 'temas/maven-lombok.php',
  'fundamentos/core-spring-ioc' => 'temas/core-spring-ioc.php',

  'core-spring-boot/solid-capas' => 'temas/solid-capas.php',
  'core-spring-boot/rest-responseentity' => 'temas/rest-responseentity.php',
  'core-spring-boot/servicios-di' => 'temas/servicios-di.php',
  'core-spring-boot/hibernate-orm' => 'temas/hibernate-orm.php',

  'persistencia-dtos/asociaciones-consultas' => 'temas/asociaciones-consultas.php',
  'persistencia-dtos/dtos-repositorios' => 'temas/dtos-repositorios.php',

  'calidad-ops/validaciones-errores' => 'temas/validaciones-errores.php',
  'calidad-ops/logs-perfiles-swagger' => 'temas/logs-perfiles-swagger.php',

  'testing/junit5-mockito' => 'temas/junit5-mockito.php',
  'testing/spring-boot-test' => 'temas/spring-boot-test.php',

  'seguridad-docker/jwt-docker' => 'temas/jwt-docker.php',
];

$target = $aliasMap[$relativeDir] ?? null;
if ($target === null) {
  http_response_code(404);
  echo 'Ruta no encontrada';
  return;
}

$targetPath = $projectRoot . '/' . ltrim($target, '/');
if (!file_exists($targetPath)) {
  http_response_code(404);
  echo 'Destino no encontrado';
  return;
}

include_once $targetPath;
