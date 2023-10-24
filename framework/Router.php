<?php

namespace framework;


use exception\MultipleRoutesFoundException;
use exception\NoRouteFoundException;

class Router
{
  private $routesList;

  public function __construct()
  {
    // Charger le fichier de routes json
    $stringRoute = file_get_contents('config/route.json');
    // Transformer le fichier en objet et les mettre dans la propriété routesList
    $this->routesList = json_decode($stringRoute);
  }

  public function findRoute(HttpRequest $httpRequest, string $basepath): Route
  {
    $url = str_replace($basepath, "", $httpRequest->getUrl());
		$method = $httpRequest->getMethod();
    // Rechercher la ou les routes associées à cette requête http
    // array_filter retourne un tableau, dans lequel tout les éléments répondant à la condition sont présent
    // Pour pouvoir utiliser une variable à l’intérieur de la portée, il faut préciser avec le mot clé "use"
    $routeFound = array_filter($this->routesList,function($route) use ($url, $method){
      // preg_match(pattern, chaine d'entree)
      return preg_match("#^" . $route->path . "$#", $url) && $route->method == $method;
    });
    $numberRoute = count($routeFound);
    if ($numberRoute > 1) {
      throw new MultipleRoutesFoundException();
    } else if ($numberRoute == 0) {
      throw new NoRouteFoundException($httpRequest);
    } else {
      // Retourner un objet Route construit à partir de la route trouvee
      // array_shift retourne le premier element
      return new Route(array_shift($routeFound));
    }
  }
}
