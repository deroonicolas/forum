<?php

namespace exception;

use Exception;

class NoRouteFoundException extends Exception
{
  public function __construct($message = "Pas de route trouvée")
  {
    parent::__construct($message, "0002");
  }
}
