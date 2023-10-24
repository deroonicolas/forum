<?php

namespace exception;

use Exception;

class ControllerNotFoundException extends Exception
{
  public function __construct($message = "Le contrôleur n'a pas été trouvé")
  {
    parent::__construct($message, "0006");
  }
}
