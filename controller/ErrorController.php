<?php

require_once('controller/BaseController.php');

class ErrorController extends BaseController
{
  public function show($exception)
  {
    $this->addParam("exception", $exception);
    $this->view("error");
  }
}
