<?php

namespace Controllers;

class Partner extends Controller {

  protected $modelName = \Models\Partner::class;

  public function getAllPartners() {
    \Auth::authentification();

    $partners = $this->model->findAll();
    $title = "Profile";
    \Vue::render("user/profile", compact(
        "title", 
        "partners"
      )
    );
  }

  public function getOnePartner($id) {
    \Auth::authentification();

    $title = "Partner";
    $userId = $_SESSION['userId'] ?? null;
    $partnerId = $id ?? null; 

    if($partnerId) { 
      $partner = $this->model->findById($partnerId);

      $voteManager = new \Models\Vote();
      $likes = $voteManager->findVotesByPartner($partnerId, "like_count");
      $dislikes = $voteManager->findVotesByPartner($partnerId, "dislike_count");

      $commentManager = new \Models\Comment();
      $comments = $commentManager->findAllCommentsByPartnerId($partnerId);
    } else {
      \Location::redirect(URL . "partner/getAllPartners");
    }

    \Vue::render("partner/partner", compact(
        "title", 
        "partner", 
        "comments", 
        "likes", 
        "dislikes", 
        'userId',
        "partnerId"
      )
    ); 
  } 
}
