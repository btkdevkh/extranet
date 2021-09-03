<?php

class Security {
  public static function checkInput(string $var) {
    return htmlentities($var);
  }
}