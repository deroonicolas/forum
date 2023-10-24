<?php

namespace framework;

use Exception;
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

  public function __construct($route)
  {
    $this->path = $route->path;
    $this->controller = $route->controller;
    $this->action = $route->action;
    $this->method = $route->method;
    $this->params = $route->params;
    $this->managers = $route->managers;
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
        $controller->{$this->action}(...$httpRequest->getParam());
      } else {
        throw new ActionNotFoundException();
      }
    } else {
      throw new ControllerNotFoundException();
    }
  }
}
