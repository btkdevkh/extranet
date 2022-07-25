<?php

class Auth {
  public static function verifySession() {
    if(session_status() === PHP_SESSION_NONE) {
      session_start();
    } 
  }

  public static function authentification() {
    if(!isset($_SESSION['authorize']) && !isset($_SESSION['access'])) {
      \Location::redirect(URL);
    }
  }
}
