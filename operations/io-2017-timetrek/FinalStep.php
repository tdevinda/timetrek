<?php
namespace GDGSriLanka\TimeTreck;
require __DIR__ . '/vendor/autoload.php';

use Endroid\QrCode\QrCode;
class FinalStep
{
	private $hash;

	private $qrWidth = 300;
	private $qrHeight = 300;

	public function __construct($hash)
	{
		$this->hash = $hash;
	}

	public function getClue($part)
	{
		$part = $part - 1;
		$qrCode = new QrCode();
	    $qrCode
	        ->setText($this->hash)
	        ->setSize($this->qrHeight)
	        ->setPadding(0)
	        ->setErrorCorrection('low')
	        ->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0])
	        ->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0])
	        ->setImageType(QrCode::IMAGE_TYPE_PNG);
	    $data = $qrCode->get();
	    $image = imagecreatefromstring($data);

	    $x = ($part % 2) * 150;
	    $y = (floor($part / 2)) * 75;

	    $imagew = imagecrop($image, ['x' => $x, 'y' => $y, 'width' => 150, 'height' => 75]);
	    ob_start();
	    imagepng($imagew);
	    $imgData = ob_get_contents();
	    ob_end_clean();
	    return $imgData;
	    //$cropped = imagecrop($image, ['x' => $x, 'y' => $y, 'width' => 150, 'height' => 75]);
	    
		// return $cropped;
	}
}


?>