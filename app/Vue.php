<?php

class Vue {
  public static function render(string $page, array $array = []) {
    ob_start();
    extract($array);
    require APPROOT . "/views/$page.html.php";
    $content = ob_get_clean();
    require APPROOT . "/views/template.html.php";
  }
}
