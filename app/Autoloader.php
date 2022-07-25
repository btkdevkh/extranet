<?php

class Autoloader {
  public static function loadClass() {
    spl_autoload_register(function($className) {
      // echo "<pre>";
      // var_dump($className);
      // echo "</pre>";
      $className = str_replace("\\", "/", $className);
      require_once APPROOT . "/$className.php";
    });
  }
}
