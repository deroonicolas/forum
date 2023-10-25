<?php

namespace framework;

use exception\ActionNotFoundException;
use exception\ControllerNotFoundException;

class Route
{
  private ?string $path;
  private ?string $controller;
  private ?string $action;
  private ?string $method;
  private ?array $params;
  private ?array $managers;

  public function __construct(string $path, string $controller, string $action, 
    string $method, array $params = [], array $managers = [])
  {
    $this->path = $path;
    $this->controller = $controller;
    $this->action = $action;
    $this->method = $method;
    $this->params = $params;
    $this->managers = $managers;
  }

  public function getPath(): ?string
  {
    return $this->path;
  }

  public function getController(): ?string
  {
    return $this->controller;
  }

  public function getAction(): ?string
  {
    return $this->action;
  }

  public function getMethod(): ?string
  {
    return $this->method;
  }

  public function getParams(): ?array
  {
    return $this->params;
  }

  public function getManagers(): ?array
  {
    return $this->managers;
  }

  public function run($httpRequest, $config)
  {
    $controller = null;
    $controllerName = $this->controller . "Controller";
    if (class_exists($controllerName)) {

      $controller = new $controllerName($httpRequest, $config);
      if (method_exists($controller, $this->action)) {
        // ... = opérateur de décomposition (https://www.php.net/manual/fr/migration56.new-features.php#migration56.new-features.variadics)
        $controller->{$this->action}(...$httpRequest->getParams());
      } else {
        throw new ActionNotFoundException();
      }
    } else {
      throw new ControllerNotFoundException();
    }
  }
}
