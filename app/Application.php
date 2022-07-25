<?php

class Application {
  public static function process() {
    $url = self::getUrl();
    // echo "<pre>";
    // var_dump($url);
    // echo "</pre>";

    $controllerName = "User";
    $task = "signin";

    if(!empty($url[0])) {
      $controllerName = ucfirst($url[0]);
    }

    if(!empty($url[1])) {
      $task = $url[1];
    }

    $controllerName = "\controllers\\" . $controllerName;

    $controller = new $controllerName();

    $controller->$task($url[2] ?? null);
  }

  protected static function getUrl() {
    if(isset($_GET['page'])) {
      $url = rtrim($_GET['page'], "/");
      $url = explode("/", filter_var($url, FILTER_SANITIZE_URL));
      return $url;
    }
  }
}
