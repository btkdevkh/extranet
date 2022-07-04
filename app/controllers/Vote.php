<?php

namespace Controllers;

class Vote extends Controller {

  protected $modelName = \Models\Vote::class;

  public function getLikes() {
    if(isset($_GET['partnerId']) && (int)$_GET['partnerId']) {
      return $this->model->findVotesByPartner($_GET['partnerId'], "like_count");
    }
  }

  public function getDislikes() {
    if(isset($_GET['partnerId']) && (int)$_GET['partnerId']) {
      return $this->model->findVotesByPartner($_GET['partnerId'], "dislike_count");
    }
  }

  public function thumbup() {
    if(isset($_POST['thumb-up'])) {
      $userId = $_POST['userId'];
      $partnerId = $_POST['partnerId'];
      $like = $_POST['like-count'];
      $like++;

      $voteByUserAndPartnerId = $this->model->findVoteByUserAndPartnerId($_SESSION['userId'], $partnerId);

      if($voteByUserAndPartnerId === false) {
        $this->model->saveVote($userId, $partnerId, $like, 'like_count');

        \Location::redirect(URL . "partner/getOnePartner/partnerId/" . $partnerId);
      } elseif($voteByUserAndPartnerId['dislike_count'] !== null) {
        $this->model->updateVoteByUserAndPartnerId($userId, $partnerId, $like, null);

        \Location::redirect(URL . "partner/getOnePartner/partnerId/" . $partnerId);
      } elseif(count($voteByUserAndPartnerId) > 1) {
        $this->model->deleteVoteByUserAndPartnerId($userId, $partnerId);
        
        \Location::redirect(URL . "partner/getOnePartner/partnerId/" . $partnerId);
      }
    } 
  }

  public function thumbDown() {
    if(isset($_POST['thumb-down'])) {
      $userId = $_POST['userId'];
      $partnerId = $_POST['partnerId'];
      $dislike = $_POST['dislike-count'];
      $dislike++;

      $voteByUserAndPartnerId = $this->model->findVoteByUserAndPartnerId($_SESSION['userId'], $partnerId);

      if($voteByUserAndPartnerId === false) {
        $this->model->saveVote($userId, $partnerId, $dislike, 'dislike_count');

        \Location::redirect(URL . "partner/getOnePartner/partnerId/" . $partnerId);
      } elseif($voteByUserAndPartnerId['like_count'] !== null) {
        $this->model->updateVoteByUserAndPartnerId($userId, $partnerId, null, $dislike);

        \Location::redirect(URL . "partner/getOnePartner/partnerId/" . $partnerId);
      } else {
        $this->model->deleteVoteByUserAndPartnerId($userId, $partnerId);

        \Location::redirect(URL . "partner/getOnePartner/partnerId/" . $partnerId);
      }
    }
  }
}
