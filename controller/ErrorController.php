<?php

use controller\BaseController;

class ErrorController extends BaseController
{
  public function show($exception)
  {
    $this->addParam("exception", $exception);
    $this->view("error");
  }
}
