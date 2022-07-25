<?php

use Controllers\Comment;
use Controllers\Partner;
use Controllers\User;
use Controllers\Vote;

class Application {
  public function __construct() {
    $url = $this->getUrl();
    // echo "<pre>";
    // var_dump($url);
    // echo "</pre>";

    $userController = new User;
    $partnerController = new Partner;
    $commentController = new Comment;
    $voteController = new Vote;

    try {
      if(!isset($url[0]) || !isset($url[1])) {
        $userController->signin();
        return;
      }

      switch ($url[1]) {
        case 'signin':
          $userController->signin();
          break;
        case 'signup':
          $userController->signup();
          break;
        case 'logoutUser':
          $userController->logoutUser();
          break;
        case 'getAllPartners':
          $partnerController->getAllPartners();
          break;
        case 'getOnePartner':
          $partnerId = $url[3] ?? null;
          $partnerController->getOnePartner($partnerId);
          break;
        case 'saveComment':
          $commentController->saveComment();
          break;
        case 'thumbUp':
          $voteController->thumbup();
          break;
        case 'thumbDown':
          $voteController->thumbDown();
          break;
        default:
          throw new Exception("Page n'existe pas");
          break;
      }
    } catch (Exception $e) {
      $msg = $e->getMessage();
      echo $msg;
    }
  }

  protected function getUrl() {
    if(isset($_GET['page'])) {
      $url = rtrim($_GET['page'], "/");
      $url = explode("/", filter_var($url, FILTER_SANITIZE_URL));
      return $url;
    }
  }
}
