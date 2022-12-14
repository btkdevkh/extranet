<?php

namespace Models;

class User extends Model {
  public function login($email) {    
    $req = 'SELECT * FROM gbaf_user WHERE username = :username OR email = :email';
    $stmt = $this->getDb()->prepare($req);
    $stmt->bindValue(':username', $email, \PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(\PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $user;
  }

  public function findUserName($username) {    
    $req = 'SELECT * FROM gbaf_user WHERE username = :username';
    $stmt = $this->getDb()->prepare($req);
    $stmt->bindValue(':username', $username, \PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(\PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $user;
  }

  public function save($lastname, $firstname, $username, $email, $pass, $question, $response) {
    $req = "INSERT INTO gbaf_user 
            (lastname, firstname, username, email, pass, question, response, createdAt) VALUES 
            (:lastname, :firstname, :username, :email, :pass, :question, :response, NOW())";
    $stmt = $this->getDb()->prepare($req);
    $stmt->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
    $stmt->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
    $stmt->bindValue(':username', $username, \PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
    $stmt->bindValue(':pass', $pass, \PDO::PARAM_STR);
    $stmt->bindValue(':question', $question, \PDO::PARAM_STR);
    $stmt->bindValue(':response', $response, \PDO::PARAM_STR);
    $stmt->execute();
    $stmt->closeCursor();
  }

  public function updateUserPassword($password, $email) {    
    $req = 'UPDATE gbaf_user SET pass = :pass WHERE email = :email';
    $stmt = $this->getDb()->prepare($req);
    $stmt->bindValue(':pass', $password, \PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
    $stmt->execute();
    $stmt->closeCursor();
  }

  public function validateUserAccount ($email) {
    $req = 'UPDATE gbaf_user SET is_activated = :is_activated WHERE email = :email';
    $stmt = $this->getDb()->prepare($req);
    $stmt->bindValue(':is_activated', 1, \PDO::PARAM_INT);
    $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
    $stmt->execute();
    $stmt->closeCursor();
  }
}
