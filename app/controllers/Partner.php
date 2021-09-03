<?php

namespace Controllers;

class Partner extends Controller {

  protected $modelName = \Models\Partner::class;

  public function getAllPartners() {
    \Auth::authentification();

    $partners = $this->model->findAll();
    $title = "Profile";
    \Vue::render("user/profile", compact("title", "partners"));
  }

  public function getOnePartner() {
    \Auth::authentification();

    if(isset($_GET['partnerId']) && (int)$_GET['partnerId']) { 

      $partner = $this->model->findById($_GET['partnerId']);

      $commentManager = new \Models\Comment();
      $comments = $commentManager->findAllByPartner($_GET['partnerId']);

      $voteManager = new \Models\Vote();
      $likes = $voteManager->findVotesByPartner($_GET['partnerId'], "like_count");
      $dislikes = $voteManager->findVotesByPartner($_GET['partnerId'], "dislike_count");

      $title = "Partner";
      $partnerId = $_GET['partnerId']; 

    } else {
      \Location::redirect("index.php?controller=partner&task=getAllPartners");
    }

    \Vue::render("partner/partner", compact("title", "partner", "comments", "likes", "dislikes", "partnerId")); 
  } 
  
}
