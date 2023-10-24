<?php

namespace controller;

class HomeController extends BaseController
{
  public function Home()
  {
    $this->view("home");
  }
}
