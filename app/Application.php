<?php

class Application {

  public static function process() {

    $controllerName = "User";
    $task = "signin";

    if(!empty($_GET['controller'])) {
      $controllerName = ucfirst($_GET['controller']);
    }

    if(!empty($_GET['task'])) {
      $task = $_GET['task'];
    }

    $controllerName = "\controllers\\" . $controllerName;

    $controller = new $controllerName();
    $controller->$task();
  }

}
