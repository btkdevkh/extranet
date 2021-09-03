<?php

class Vue {
  public static function render(string $page, array $array = []) {
    extract($array);
    ob_start();
    require('views/'.$page.'.html.php');
    $content = ob_get_clean();
    require('views/template.html.php');
  }
}
