<?php

require_once('controller/BaseController.php');
class HomeController extends BaseController
{
  public function home()
  {
    $this->view("home");
  }
}
