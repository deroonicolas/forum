<?php

namespace framework;

use PDO;

/**  Connexion à la base de données */
class BDD
{
  private ?PDO $dataBase;
  private static ?BDD $instance;

  private function __construct()
  {
    $this->dataBase = new PDO(
      'mysql:dbname=' . getenv("DB_NAME") . ';host=' . getenv("DB_HOST"),
      getenv("DB_USER"), getenv("DB_PASSWORD"));
  }

  public static function getInstance(): ?PDO
  {
    if (empty(self::$instance)) {
      self::$instance = new BDD();
    }
    return self::$instance->dataBase;
  }

}
