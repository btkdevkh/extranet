<?php

use Controllers\Comment;
use Controllers\Partner;
use Controllers\User;
use Controllers\Vote;

class Application {
  public static function process() {
    $user = new User();
    $partner = new Partner();
    $comment = new Comment();
    $vote = new Vote();

    try {
      if(empty($_GET['page'])) {
        $user->signin();
      } else {
        $url = explode("/", filter_var($_GET['page'], FILTER_SANITIZE_URL));
        // echo "<pre>";
        // var_dump($url);
        // echo "</pre>";

        if(empty($url[0]) || empty($url[1])) throw new Exception("Page n'existe pas");

        switch ($url[1]) {
          case 'signin':
            $user->signin();
            break;
          case 'forgotPassword':
            $user->forgotPassword();
            break;
          case 'resetPassword':
            $param = $url[3] ?? null;
            $user->resetPassword($param);
            break;
          case 'signup':
            $user->signup();
            break;
          case 'logoutUser':
            $user->logoutUser();
            break;
          case 'getAllPartners':
            $partner->getAllPartners();
            break;
          case 'getOnePartner':
            $partnerId = $url[3] ?? null;
            $partner->getOnePartner($partnerId);
            break;
          case 'saveComment':
            $comment->saveComment();
            break;
          case 'thumbUp':
            $vote->thumbup();
            break;
          case 'thumbDown':
            $vote->thumbDown();
            break;
          default:
            throw new Exception("Page n'existe pas");
            break;
        }
      }
    } catch (Exception $e) {
      $msg = $e->getMessage();
      echo $msg;
    }
  }
}
