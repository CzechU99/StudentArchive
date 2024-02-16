<?php

  $path = isset($_GET['path']) ? $_GET['path'] : null;

  if ($path) {
      $folderSizeKB = getFolderSize($path);
      $response = ['folderSize' => $folderSizeKB];
      header('Content-Type: application/json');
      echo json_encode($response);
  } else {
      header('HTTP/1.1 400 Bad Request');
      echo json_encode(['error' => 'Invalid request']);
  }

  function getFolderSize($path) {
      $totalSize = 0;
      $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
      foreach ($files as $file) {
          if ($file->isFile()) {
              $totalSize += $file->getSize();
          }
      }
      return round($totalSize / 1024, 2);
  }
  
?>