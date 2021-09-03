<?php

namespace Models;

class Comment extends Model {
 
  public function save($content, $user_id, $partner_id) {
    $req = "INSERT INTO gbaf_comment
      (content, createdAt, user_id, partner_id) VALUES 
      (:content, NOW(), :user_id, :partner_id)";
    $stmt = $this->getDb()->prepare($req);
    $stmt->bindValue(':content', $content, \PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
    $stmt->bindValue(':partner_id', $partner_id, \PDO::PARAM_INT);
    $stmt->execute();
    $stmt->closeCursor();
  }

  public function findAllByPartner($partner_id) {
    $req = "SELECT gbaf_comment.content, 
            DATE_FORMAT(gbaf_comment.createdAt, '%d/%m/%Y at %Hh:%mm:%ss') as dateFr, 
            gbaf_user.firstName 
            FROM gbaf_comment 
            INNER JOIN gbaf_user 
            ON gbaf_comment.user_id = gbaf_user.id
            WHERE gbaf_comment.partner_id = :partner_id ORDER BY gbaf_comment.id DESC";
    $stmt = $this->getDb()->prepare($req);
    $stmt->bindValue(':partner_id', $partner_id, \PDO::PARAM_INT);
    $stmt->execute();
    $comments = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $comments;
  }
  
}
