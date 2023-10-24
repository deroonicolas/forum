<?php

use exception\PropertyNotFoundException;
use framework\BDD;

class BaseManager
{
  private $table;
  private $object;
  protected $dataBase;

  public function __construct($table, $object, $dataSource)
  {
    $this->table = $table;
    $this->object = $object;
    $this->dataBase = BDD::getInstance($dataSource);
  }

  public function findAll(): array|false
  {
    $req = $this->dataBase->prepare("SELECT * FROM " . $this->table);
    $req->execute();
    $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->object);
    return $req->fetchAll();
  }

  public function findById($id): mixed
  {
    $req = $this->dataBase->prepare("SELECT * FROM " . $this->table . " WHERE id = ?");
    $req->execute(array($id));
    $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->object);
    return $req->fetch();
  }

  public function create($object, $paramNames): void
  {
    $paramNumber = count($paramNames);
    $valueArray = array_fill(1, $paramNumber, "?");
    $valueString = implode(", ", $valueArray);
    $sql = "INSERT INTO " . $this->table . "(" . implode(", ", $paramNames) . ") VALUES(" . $valueString . ")";
    $req = $this->dataBase->prepare($sql);
    $boundParam = array();
    foreach ($paramNames as $paramName) {
      if (property_exists($object, $paramName)) {
        $boundParam[$paramName] = $object->$paramName;
      } else {
        throw new PropertyNotFoundException($this->object, $paramName);
      }
    }
    $req->execute($boundParam);
  }

  public function update($obj, $param): void
  {
    $sql = "UPDATE " . $this->table . " SET ";
    foreach ($param as $paramName) {
      $sql = $sql . $paramName . " = ?, ";
    }
    $sql = $sql . " WHERE id = ? ";
    $req = $this->dataBase->prepare($sql);

    $param[] = 'id';
    $boundParam = array();
    foreach ($param as $paramName) {
      if (property_exists($obj, $paramName)) {
        $boundParam[$paramName] = $obj->$paramName;
      } else {
        throw new PropertyNotFoundException($this->object, $paramName);
      }
    }

    $req->execute($boundParam);
  }

  public function delete($obj): bool
  {
    if (property_exists($obj, "id")) {
      $req = $this->dataBase->prepare("DELETE FROM " . $this->table . " WHERE id=?");
      return $req->execute(array($obj->id));
    } else {
      throw new PropertyNotFoundException($obj, "id");
    }
  }
}
