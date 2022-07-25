<?php

namespace Controllers;

class Comment extends Controller {

  protected $modelName = \Models\Comment::class;

  public function saveComment() {
    if(isset($_POST['comment-submit'])) {
      if(empty($_POST['comment'])) {
        \Location::redirect(URL . "partner/getAllPartners");
      } else {
        $userId = $_POST['userId'];
        $partnerId = $_POST['partnerId'];
        $comment = $_POST['comment'];
        $this->model->save($comment, $userId, $partnerId);
        \Location::redirect(URL . "partner/getOnePartner/" . $partnerId);
      }
    }
  }
}
