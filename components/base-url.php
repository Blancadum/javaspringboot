<?php
  if (!isset($base_url)) {
    $script_path = str_replace(chr(92), '/', $_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF']);
    $uri_path = str_replace(chr(92), '/', strtok($_SERVER['REQUEST_URI'] ?? '', '?'));
    $resolved_path = $uri_path;

    if (empty($resolved_path) || $resolved_path === '/') {
      $resolved_path = $script_path;
    }

    $target_path = (strpos($resolved_path, 'guia-estudio') !== false) ? $resolved_path : $script_path;
    $pos = strpos($target_path, 'guia-estudio');

    if ($pos !== false) {
      $sub_path = trim(substr($target_path, $pos + strlen('guia-estudio')), '/');
      if (empty($sub_path)) {
        $base_url = '';
      } else {
        $parts = array_values(array_filter(explode('/', $sub_path), fn($part) => $part !== ''));
        if (!empty($parts) && preg_match('/\.php$/i', $parts[count($parts) - 1])) {
          array_pop($parts);
        }
        $depth = count($parts);
        $base_url = ($depth > 0) ? str_repeat('../', $depth) : '';
      }
    } else {
      $base_url = '';
    }
  }
?>
