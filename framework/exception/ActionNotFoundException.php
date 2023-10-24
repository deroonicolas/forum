<?php

namespace exception;

use Exception;

class ActionNotFoundException extends Exception
{
  public function __construct($message = "L'action n'a pas été trouvée")
  {
    parent::__construct($message, "0005");
  }
}
