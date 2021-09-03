<?php

namespace Models;

class Vote extends Model {

  public function saveVote($user_id, $partner_id, $vote, $col) {
    $req = "INSERT INTO gbaf_vote
      (createdAt, user_id, partner_id, {$col}) VALUES 
      (NOW(), :user_id, :partner_id, :{$col})";
    $stmt = $this->getDb()->prepare($req);
    $stmt->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
    $stmt->bindValue(':partner_id', $partner_id, \PDO::PARAM_INT);
    $stmt->bindValue(':'.$col, $vote, \PDO::PARAM_INT);
    $stmt->execute();
    $stmt->closeCursor();
  }

  public function findVotesByPartner($partner_id, $col) {
    $req = "SELECT {$col} FROM gbaf_vote WHERE partner_id = :partner_id AND {$col} > 0";
    $stmt = $this->getDb()->prepare($req);
    $stmt->bindValue(':partner_id', $partner_id, \PDO::PARAM_INT);
    $stmt->execute();
    $votes = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $votes;
  }

  public function findVoteByUserAndPartnerId($user_id, $partner_id) {
    $req = "SELECT * FROM gbaf_vote WHERE user_id = :user_id AND partner_id = :partner_id";
    $stmt = $this->getDb()->prepare($req);
    $stmt->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
    $stmt->bindValue(':partner_id', $partner_id, \PDO::PARAM_INT);
    $stmt->execute();
    $vote = $stmt->fetch(\PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $vote;
  }

  public function updateVoteByUserAndPartnerId($user_id, $partner_id, $vote1, $vote2) {
    $req = "UPDATE gbaf_vote SET like_count = :like_count, dislike_count = :dislike_count WHERE user_id = :user_id AND partner_id = :partner_id";
    $stmt = $this->getDb()->prepare($req);
    $stmt->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
    $stmt->bindValue(':partner_id', $partner_id, \PDO::PARAM_INT);
    $stmt->bindValue(':like_count', $vote1, \PDO::PARAM_INT);
    $stmt->bindValue(':dislike_count', $vote2, \PDO::PARAM_INT);
    $stmt->execute();
  }

  public function deleteVoteByUserAndPartnerId($user_id, $partner_id) {
    $req = "DELETE FROM gbaf_vote WHERE user_id = :user_id AND partner_id = :partner_id";
    $stmt = $this->getDb()->prepare($req);
    $stmt->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
    $stmt->bindValue(':partner_id', $partner_id, \PDO::PARAM_INT);
    $stmt->execute();
    $stmt->closeCursor();
  }

}
