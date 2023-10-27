<?php

require_once('controller/BaseController.php');

class DashboardController extends BaseController
{
  public function Dashboard()
  {
    $this->view("dashboard");
  }
}