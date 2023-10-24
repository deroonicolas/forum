<?php

namespace framework;
use PDO;

/**  Connexion à la base de données */
class BDD
{
  private ?PDO $dataBase;
  private static ?BDD $instance;

  private function __construct($dataSource)
  {
    $this->dataBase = new PDO(
      'mysql:dbname=' . $dataSource->dbname . ';host=' . $dataSource->host,
      $dataSource->user, $dataSource->password);
  }

  public static function getInstance($dataSource): ?PDO
  {
    if (empty(self::$instance)) {
      self::$instance = new BDD($dataSource);
    }
    return self::$instance->dataBase;
  }

}
