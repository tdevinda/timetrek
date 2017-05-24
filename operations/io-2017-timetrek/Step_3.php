<?php
namespace GDGSriLanka\TimeTreck;

class Step_3
{
	private $clue;
	private $image;
	private $SQUARESIZE = 50;
	private $colorValues = array(
		array(0, 0, 0, 0),
		array(0, 0, 255, 0),
		array(0, 255, 0, 0),
		array(0, 255, 255 , 0),
		array(255, 0, 0, 0),
		array(255, 0, 255, 0),
		array(255, 255, 0, 0),
		array(255, 255, 255, 0),
		array(0, 0, 0, 1),
		array(0, 0, 255, 1),
		array(0, 255, 0, 1),
		array(0, 255, 255 , 1),
		array(255, 0, 0, 1),
		array(255, 0, 255, 1),
		array(255, 255, 0, 1),
		array(255, 255, 255, 1),
		);
	private $colors = array();
	private $colorPolkadot;
	private $txtColor;

	public function __construct($clue)
	{
		$this->clue = $clue;
		$this->interchangeColors();
		$this->initSystem();
	}


	public function getOutput()
	{
		$hexString = "";
		for($i =0;$i < strlen($this->clue);$i++)
		{
			$hexString .= dechex(ord(substr($this->clue, $i, 1)));

		}
		
		$this->createColorStrip($hexString);
		ob_start();
		imagepng($this->image);
		$contentString = ob_get_contents();
		ob_end_clean();
		return $contentString;
	}


	public function getDescription()
	{
		
		$strip = imagecreate($this->SQUARESIZE * 16, $this->SQUARESIZE);

		$polkadot = imagecolorallocate($strip, 255, 152, 0);
		$txt = imagecolorallocate($strip, 127, 127, 127);

		for($i=0;$i < 16;$i++)
		{
			imagefilledrectangle($strip, $i * $this->SQUARESIZE, 0, ($i + 1) * $this->SQUARESIZE, $this->SQUARESIZE, 
				imagecolorallocate($strip, 	$this->colorValues[$i][0], 	$this->colorValues[$i][1], 	$this->colorValues[$i][2]));

			if($this->colorValues[$i][3] == 1)
			{
				imagefilledellipse($strip , ($i * $this->SQUARESIZE) + ($this->SQUARESIZE / 2), ($this->SQUARESIZE / 2), 20, 20,$polkadot);
			}

			imagestring($strip, 2, ($i * $this->SQUARESIZE) + ($this->SQUARESIZE / 4), ($this->SQUARESIZE / 4), $i . "cm", $txt);	
		}
		

		ob_start();
		imagepng($strip);
		$contentString = ob_get_contents();
		ob_end_clean();

		return $contentString;
	}

	private function interchangeColors()
	{
		$swaps = rand(1,5);
		while($swaps-- > 0) 
		{
			$a = rand(0, 15);
			$b = rand(0, 15);

			if($a == $b) {
				$b = $a + 1;
				if($b == 16) 
				{
					$b = 14;
				}
			}

			$temp = $this->colorValues[$a];
			$this->colorValues[$a] = $this->colorValues[$b];
			$this->colorValues[$b] = $temp;
		}
	}

	private function initSystem()
	{
		$this->image = imagecreate(strlen($this->clue) * 2 * $this->SQUARESIZE, $this->SQUARESIZE);
		foreach ($this->colorValues as $colorValue) {
			array_push($this->colors, imagecolorallocate($this->image, $colorValue[0], $colorValue[1], $colorValue[2]));
		}
		$this->colorPolkadot = imagecolorallocate($this->image, 255, 152, 0);
		$this->txtColor = imagecolorallocate($this->image, 255, 180, 60);
	}

	private function drawHex($value, $position)
	{
		imagefilledrectangle($this->image, $position * $this->SQUARESIZE, 0, ($position + 1) * $this->SQUARESIZE, $this->SQUARESIZE, $this->colors[$value]);
		if($this->colorValues[$value][3] == 1)
		{
			imagefilledellipse($this->image , ($position * $this->SQUARESIZE) + ($this->SQUARESIZE / 2), ($this->SQUARESIZE / 2), 20, 20, $this->colorPolkadot);
		}

		//debug code
		//imagestring($this->image, 1, ($position * $this->SQUARESIZE) + ($this->SQUARESIZE / 2), ($this->SQUARESIZE / 2), dechex($value), $this->txtColor);
	}

	private function createColorStrip($string)
	{
		for($i=0;$i < strlen($string); $i++)
		{
			$this->drawHex(intval(substr($string, $i, 1), 16), $i);
		}
	}


	// private function createColorStrip($string)
	// {
		
	// 	header("Content-Type: image/png");
		

	// 	return $strip;
	// }
}

?>