<?php
  if (!isset($base_url)) {
    $project_root = str_replace('\\', '/', realpath(dirname(__DIR__)) ?: dirname(__DIR__));
    $script_file = str_replace('\\', '/', realpath($_SERVER['SCRIPT_FILENAME'] ?? '') ?: ($_SERVER['SCRIPT_FILENAME'] ?? ''));
    $script_name = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF'] ?? '');

    $rel_file = '';
    if (!empty($script_file) && strpos($script_file, $project_root) === 0) {
      $rel_file = substr($script_file, strlen($project_root));
    }

    $web_root = '';
    if (!empty($rel_file) && strlen($script_name) >= strlen($rel_file) && substr($script_name, -strlen($rel_file)) === $rel_file) {
      $web_root = substr($script_name, 0, strlen($script_name) - strlen($rel_file));
    } else {
      $web_root = rtrim(dirname($script_name), '/');
      if ($web_root === '/' || $web_root === '\\') {
        $web_root = '';
      }
    }

    $base_url = rtrim($web_root, '/') . '/';
  }
?>

