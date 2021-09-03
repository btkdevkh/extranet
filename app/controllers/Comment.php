<?php

namespace Controllers;

class Comment extends Controller {

  protected $modelName = \Models\Comment::class;

  public function getAllComments() {
    if(isset($_GET['partnerId']) && (int)$_GET['partnerId']) {
      $this->model->findAllByPartner($_GET['partnerId']);
    }
  }

  public function saveComment() {
    if(isset($_POST['comment-submit'])) {
      if(empty($_POST['comment'])) {
        \Location::redirect("index.php?controller=partner&task=getAllPartners");
      } else {
        $userId = $_POST['userId'];
        $partnerId = $_POST['partnerId'];
        $comment = $_POST['comment'];
        $this->model->save($comment, $userId, $partnerId);
        \Location::redirect("index.php?controller=partner&task=getOnePartner&partnerId=" . $partnerId);
      }
    }
  }

}
