<?php
namespace GDGSriLanka\TimeTreck;
/**
clue for next step using terminal text decoration
*/
require __DIR__ . '/vendor/autoload.php';
use Povils\Figlet\Figlet;

class QuestionA
{
  private $hash;
  private $path;

  public function __construct($path, $hash)
  {
    $this->path = $path;
    $this->hash = $hash;
  }


  public function getClueForPath()
  {

    $figlet = new Figlet();
    $txt = $figlet->render("/". $this->path .'#'. $this->hash);

    $txt = str_replace("\n"," @",$txt);
    $txt = str_replace(" ",".",$txt);

    return $txt;
    // return "";
  }
}




 ?>
