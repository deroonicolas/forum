<?php

class User
{
  private $id;
  private $mail;
  private $password;

  public function getId(): int
  {
    return $this->id;
  }

  public function getMail(): string
  {
    return $this->mail;
  }

  public function setMail($mail): self
  {
    $this->mail = $mail;
    return $this;
  }

  public function getPassword(): string
  {
    return $this->password;
  }

  public function setPassword($password): self
  {
    $this->password = $password;
    return $this;
  }
}
