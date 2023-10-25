<?php

require_once('framework/FileManager.php');

use exception\ViewNotFoundException;
use framework\FileManager;
use framework\HttpRequest;

class BaseController
{
  private ?HttpRequest $httpRequest;
  private ?array $params;
  private $config;
  private ?FileManager $fileManager;

  public function __construct($httpRequest, $config)
  {
    $this->httpRequest = $httpRequest;
    $this->config = $config;
    $this->params = array();
    $this->addParam("httprequest", $this->httpRequest);
    $this->addParam("config", $this->config);
    $this->bindManager();
    $this->fileManager = new FileManager();
  }

  protected function view(string $fileName): void
  {
    $controller = $this->httpRequest->getRoute()->getController();
    if (file_exists("view/" . $controller . "/css/" . $fileName . ".css")) {
      $this->addCss("view/" . $controller . "/css/" . $fileName . ".css");
    }
    if (file_exists("view/" . $controller . "/js/" . $fileName . ".js")) {
      $this->addJs("view/" . $controller . "/js/" . $fileName . ".js");
    }
    if (file_exists('view/' . $controller . "/" . $fileName . '.php')) {
      // ob_start() pour indiquer que l'on veux mettre l'affichage en mémoire au lieu de l'envoyer au navigateur
      ob_start();
      // Etant donné que les paramètres sont sous format de tableau dans le base contrôleur,
      // on peut utiliser extract() pour les extraire et qu'une variable soit créée pour chaque case du tableau.
      extract($this->params);
      include('view/' . $controller . "/" . $fileName . '.php');
      // ob_get_clean récupère le contenu généré, et efface le tampon
      $content = ob_get_clean();
      include("view/layout.php");
    } else {
      throw new ViewNotFoundException();
    }
  }

  public function bindManager(): void
  {
    // Ajout propriétés dynamiques
    foreach ($this->httpRequest->getRoute()->getManagers() as $manager) {
      $this->$manager = new $manager($this->config->database);
    }
  }

  // Ajout d'un paramètre à la liste des params, avec pour chaque, un nom et une valeur
  public function addParam($name, $value): void
  {
    $this->params[$name] = $value;
  }

  public function addCss($file): void
  {
    $this->fileManager->addCss($file);
  }

  public function addJs($file): void
  {
    $this->fileManager->addJs($file);
  }
  
}
