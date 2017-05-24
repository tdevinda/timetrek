<?php

namespace GDGSriLanka\TimeTreck;

use Povils\Figlet\Figlet;

class FigletQuestion{

  public static function getOutput($answer) {

    $figlet = new Figlet();
    $txt = $figlet->render($answer);

    $txt = str_replace("\n"," @",$txt);
    $txt = str_replace(" ",".",$txt);

    return $txt;
  }


}
