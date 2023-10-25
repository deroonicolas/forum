<?php

namespace exception;

use Exception;
use framework\HttpRequest;

class NoRouteFoundException extends Exception
{
  private HttpRequest $httpRequest;

  public function __construct($httpRequest, $message = "Aucune route n'a été trouvée")
  {
    $this->httpRequest = $httpRequest;
    parent::__construct($message, "0002");
  }

  public function getMoreDetail(): string
  {
    return "La Route '" . $this->httpRequest->getUrl() . "' n'a pas été trouvée avec la méthode '" 
      . $this->httpRequest->getMethod() . "'";
  }
}
