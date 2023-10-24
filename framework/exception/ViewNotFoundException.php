<?php

namespace exception;

use Exception;

class ViewNotFoundException extends Exception
{
  public function __construct($message = "Pas de vue trouvée")
  {
    parent::__construct($message, "0003");
  }
}
