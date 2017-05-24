<?php
	namespace GDGSriLanka\TimeTreck;
    // header('Access-Control-Allow-Origin: https://timetrek.gdgsrilanka.org');
  header('Access-Control-Allow-Origin: *');
	
	use Endroid\QrCode\QrCode;
	include_once('UserDetails.php');
	require __DIR__ . '/vendor/autoload.php';

	$START = "start";
	$KOTTE = "veediyabandara";
	$GAMPOLA = "madolkurupawa";
	$KURUNEGALA = "ektamge";
    $YAPAHUWA = "buwaneka";
    $DAMBADENIYA = "maligagala";
    $POLONNARUWA = "sathmahala";
    $ANURADHAPURA = "alakamanda";

	$email = $_REQUEST['e'];
	$path = preg_replace('/^(\/)?([a-zA-Z]+)(\/)?$/', '$2', $_REQUEST['p']);
    $anchor = preg_replace('/^(#)?([a-fA-F0-9]+)/', '$2', $_REQUEST['a']);
    // $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    
    $userDetails = new UserDetails($email);
	  $finalStep = new FinalStep("/present-time#". $userDetails->getHashForStep(5));
    


    if($path == $START) 
    {
    	$data['d'] = '<img class="tmdata" alt="part number: R4" src="data:image/png;base64,'. base64_encode($finalStep->getClue(8)) .'" />Part Number R4';
    	echo json_encode($data);
    }
    else if($path == $KOTTE) 
    {
    	$data['d'] = '<img class="tmdata" alt="part number: L4" src="data:image/png;base64,'. base64_encode($finalStep->getClue(7)) .'" /> Part Number L4';
    	echo json_encode($data);
    }
    else if($path == $GAMPOLA) 
    {
    	$data['d'] = '<img class="tmdata" alt="part number: R3" src="data:image/png;base64,'. base64_encode($finalStep->getClue(6)) .'" /> Part Number R3';
    	echo json_encode($data);
    }
    else if($path == $KURUNEGALA)
    {
    	$data['d'] = '<img class="tmdata" alt="part number: L3" src="data:image/png;base64,'. base64_encode($finalStep->getClue(5)) .'" /> part number L3';
    	echo json_encode($data);
    }
    else if($path == $YAPAHUWA)
    {
      if($userDetails->getHashForStep(1) == $anchor)
      {
     	
    	$data['d'] = '<img class="tmdata" alt="part number: R2" src="data:image/png;base64,'. base64_encode($finalStep->getClue(4)) .'" /> Part Number R2';
    	echo json_encode($data);
      }
      else
      {
        $clue['c'] = "Portal parts are out of stock!";
        $clue['status'] = "key";
        echo json_encode($clue);
      }
    } 
    else if($path == $DAMBADENIYA)
    {
      if($userDetails->getHashForStep(2) == $anchor)
      {
       	$data['d'] = '<img class="tmdata" alt="part number: L2" src="data:image/png;base64,'. base64_encode($finalStep->getClue(3)) .'" /> Part Number L2';
    	echo json_encode($data);
      }
      else
      {
        $clue['c'] = "Portal parts are out of stock!";
        $clue['status'] = "key";
        echo json_encode($clue);
      }
    }
    else if($path == $POLONNARUWA)
    {
      if($userDetails->getHashForStep(3) == $anchor)
      {
		$data['d'] = '<img class="tmdata" alt="part number: R1" src="data:image/png;base64,'. base64_encode($finalStep->getClue(2)) .'" /> Part Number R1';
    	echo json_encode($data);
      }
      else
      {
        $clue['c'] = "Portal parts are out of stock!";
        $clue['status'] = "key";
        echo json_encode($clue);
      }
    }
    else if($path == $ANURADHAPURA) 
    {
      if($userDetails->getHashForStep(4) == $anchor)
      {
        $data['d'] = '<img class="tmdata" alt="part number: L1" src="data:image/png;base64,'. base64_encode($finalStep->getClue(1)) .'" /> Part Number L1';
    	echo json_encode($data);
        
      }
      else
      {
        $clue['c'] = "Portal parts are out of stock!";
        $clue['status'] = "key";
        echo json_encode($clue);
      }
    } else {
      echo '{"status": "ok", "path": "'. $path .'"}';  //daddy of all misleadings. ;)
    }




?>