<?php
namespace GDGSriLanka\TimeTreck;
require __DIR__ . '/vendor/autoload.php';

use Povils\Figlet\Figlet;
use Picqer\Barcode;

class QuestionB
{
  private $path;
  private $hash;

  public function __construct($path, $hash)
  {
    $this->path = $path;
    $this->hash = $hash;
  }

  public function getClueForPath()
  {
    $generatorPNG = new \Picqer\Barcode\BarcodeGeneratorPNG();
    // header("Content-Type: image/png"); 
    return $generatorPNG->getBarcode("/". $this->path ."#". $this->hash, $generatorPNG::TYPE_CODE_128, 4, 2);
  }
}

 ?>
