<?php

namespace exception;

use Exception;

class PropertyNotFoundException extends Exception
{
  public function __construct($message = "La propriété n'a pas été trouvée : ", $property)
  {
    parent::__construct($message . $property, "0004");
  }
}
