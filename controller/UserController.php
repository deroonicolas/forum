<?php

class UserController extends BaseController
{
  private $userManager;

  private function getUserManager()
  {
    if (!$this->userManager) {
      $this->userManager = new UserManager();
    }
    return $this->userManager;
  }

  public function login()
  {
    $this->view("login");
  }

  public function Authenticate($login, $password)
  {
    $user = $this->getUserManager()->getByMail($login);
    // DashboardController->view("dashboard");
  }
}
