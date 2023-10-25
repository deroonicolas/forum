<?php

require_once('controller/BaseController.php');
class HomeController extends BaseController
{
  public function Home()
  {
    $this->view("home");
  }
}
