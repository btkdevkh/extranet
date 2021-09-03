<?php

class Autoloader {
  public static function loadClass() {
    spl_autoload_register(function($className) {
      // var_dump($className);
      $className = str_replace("\\", "/", $className);
      require_once("app/$className.php");
    });
  }
}
