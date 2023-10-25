<?php

namespace framework;
class FileManager
{
  private ?array $cssFilesList;
  private ?array $jsFilesList;

  public function __construct()
  {
    $this->cssFilesList = array();
    $this->jsFilesList = array();
  }

  public function addJs($file)
  {
    $this->jsFilesList[] = $file;
  }

  public function addCss($file): static
  {
    $this->cssFilesList[] = $file;
    return $this;
  }

  public function generateJs(): string
  {
    $jsContent = '';
    foreach ($this->jsFilesList as $jsFile) {
      $jsContent .= '<script src="' . $jsFile . '" ></script>';
    }
    return $jsContent;
  }

  public function generateCss(): string
  {
    $cssContent = '';
    foreach ($this->cssFilesList as $cssFile) {
      $cssContent .= '<link rel="stylesheet" type="text/css" href="' . $cssFile . '" />';
    }
    return $cssContent;
  }
}
