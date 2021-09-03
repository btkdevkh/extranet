<?php

namespace Models;

class Partner extends Model {

  protected $table = "gbaf_partner";

  public function findById($id) {    
    $req = 'SELECT * FROM gbaf_partner WHERE id = :id';
    $stmt = $this->getDb()->prepare($req);
    $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
    $stmt->execute();
    $partner = $stmt->fetch(\PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $partner;
  }

}
