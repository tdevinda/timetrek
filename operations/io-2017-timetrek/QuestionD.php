<?php
namespace GDGSriLanka\TimeTreck;
class QuestionD
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
    	$string = "/". $this->path ."#". $this->hash;
    	
    	if(strlen($string) % 3 == 1) {
    		$string .= " ";
    	} else if(strlen($string) == 2) {
    		$string .= "  ";
    	}

    	$vals = array();
    	//echo $string . "<br/>";
    	for($i=0;$i < strlen($string);$i+=3)
    	{
    		$vals[$i / 3] = dechex(ord($string[$i])) . dechex(ord($string[$i + 1])) . dechex(ord($string[$i + 2]));
    	}

    	$perSquareWidth = 50;
    	$result = '<svg width="'. count($vals) * $perSquareWidth.'" height="5" xmlns="http://www.w3.org/2000/svg"><g>';
    	
    	for($i = 0;$i < count($vals); $i++) {
    		// $result .= $vals[$i] ." ";
    		//echo $vals[$i];
    		$result .= '<rect id="svg_'. ($i + 1).'" height="5" width="'. $perSquareWidth.'" y="0" x="'. ($i * $perSquareWidth) .'" stroke-width="0" stroke="#000" fill="#'. $vals[$i] .'"/>';
    	}
    	$result .= '</g></svg>';

    	return $result;

    	
    }

}



?>