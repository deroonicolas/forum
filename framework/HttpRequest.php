<?php

namespace framework;

// Classe recevant une requete
class HttpRequest
{
  private ?string $url;
  private ?string $method;
  private ?array $params;
  private ?Route $route;

  public function __construct(string $url = null, string $method = null)
  {
    $this->url = (is_null($url)) ? $_SERVER['REQUEST_URI'] : $url;
    $this->method = (is_null($method)) ? $_SERVER['REQUEST_METHOD'] : $method;
    $this->params = array();
  }

  public function getUrl(): ?string
  {
    return $this->url;
  }

  public function getMethod(): ?string
  {
    return $this->method;
  }

  public function getParams(): ?array
  {
    return $this->params;
  }

  public function getRoute(): Route
  {
    return $this->route;
  }

  public function setRoute(Route $route): static
  {
    $this->route = $route;
    return $this;
  }

  public function bindParam()
  {
    switch ($this->method) {
      case "GET":
      case "DELETE":
        /* La case 0 correspond toujours à l'expression complete qui a été trouvée.
        A partir de la case 1, il s'agit des parenthèses capturantes dans l'ordre dans lequel elles sont présentes dans la regex. 
        Dans notre cas il n'y en a qu'une seule ([0-9]*) qui correspond au 5 de l'url.
        Il faudra donc faire une boucle dans ce tableau de résultat, en ignorant la case 0, pour l'ajouter aux params. */
        if (preg_match("#" . $this->route->getPath() . "#", $this->url, $matches)) {
          for ($i = 1; $i < count($matches) - 1; $i++) {
            $this->params[] = $matches[$i];
          }
        }
      case "POST":
      case "PUT":
        foreach ($this->route->getParams() as $param) {
          if (isset($_POST[$param])) {
            $this->params[] = $_POST[$param];
          }
        }
    }
  }

  public function run($config)
  {
    $this->route->run($this, $config);
  }

  public function addParam($value)
  {
    $this->params[] = $value;
  }
  
}
