<?php

namespace Models;

abstract class Model {

  private static $user = "root";
  private static $password = "";
  private static $dsn = 'mysql:host=localhost;dbname=gbaf_db';
  private static $pdo;

  protected $table;
  
  private static function setDb() {
    try {
      self::$pdo = new \PDO(self::$dsn, self::$user, self::$password);
      self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    } catch (\PDOException $e) {
      echo 'Connexion failed : ' . $e->getMessage();
    }
  }

  protected function getDb() {
    if(self::$pdo === null) {
      self::setDb();
    } 
    return self::$pdo;
  }

  public function findAll() {    
    $req = "SELECT * FROM {$this->table}";
    $stmt = $this->getDb()->prepare($req);
    $stmt->execute();
    $datas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $datas;
  }
}
