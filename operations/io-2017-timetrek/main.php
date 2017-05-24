<?php
    namespace GDGSriLanka\TimeTreck;
    // header('Access-Control-Allow-Origin: https://timetrek.gdgsrilanka.org');
    header('Access-Control-Allow-Origin: *');
    use Povils\Figlet\Figlet;
    use Endroid\QrCode\QrCode;
    
    include_once('UserDetails.php');
    include_once('Step_2.php');
    include_once('Step_3.php');
    include_once('QuestionA.php');
    include_once('QuestionB.php');
    include_once('QuestionC.php');
    include_once('QuestionD.php');
    include_once('FinalStep.php');
    
    require __DIR__ . '/vendor/autoload.php';
 
    $KOTTE = "veediyabandara";
    $GAMPOLA = "madolkurupawa";
    $KURUNEGALA = "ektamge";
    $YAPAHUWA = "buwaneka";
    $DAMBADENIYA = "maligagala";
    $POLONNARUWA = "sathmahala";
    $ANURADHAPURA = "alakamanda";


    
    $email = $_REQUEST['e']; //$_POST['e'];
    // $path = preg_match('/(\/)([^\/])(\/)/', $_REQUEST['p'])[1];
    $path = preg_replace('/^(\/)([a-zA-Z]+)/', '$2', $_REQUEST['p']);
    $anchor = preg_replace('/^(#)?([a-fA-F0-9]+)/', '$2', $_REQUEST['a']);
    // $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    //echo $path . "<br/>";
    $userDetails = new UserDetails($email);


    // echo $userDetails->printUser();
    if($path == $KOTTE)
    {
      $clueStyles = array("answer is /madolkurupawa", "type /madolkurupawa next", "/madolkurupawa is the answer",
        "go to gampola with /madolkurupawa");
      $step = new Step_2($clueStyles[rand(0, count($clueStyles))]);
      $clue['c'] = $step->getOutput();
      $clue['q'] = "parakum";
      $clue['f'] = $step->getDescription();
      echo json_encode($clue);
    }
    else if($path == $GAMPOLA)
    {
      $clueStyles = array("I found a path named /ektamge from research", "it was written in an old script to use /ektamge", "you didn't grant me leave so I'm going to see /ektamge by force");
      $step = new Step_3($clueStyles[rand(0, count($clueStyles) - 1)]);
      
      $clue['f'] = '<img class="ruler" height="25px" src="data:image/png;base64,'. base64_encode($step->getDescription()) .'" />';
      $clue['c'] = '<img class="dimens" height="10px" src="data:image/png;base64,'. base64_encode($step->getOutput()) .'" />';
      $clue['q'] = 'madolkurupawa';

      echo json_encode($clue);
    }
    else if($path == $KURUNEGALA)
    {
      //we don't check for authenticity in this path
      $clue['c'] = getClueContent($userDetails->getQuestionOrder()[0], $YAPAHUWA, $userDetails->getHashForStep(1));
      // $clue['c'] = getClueContent('b', $YAPAHUWA, $userDetails->getHashForStep(1));
      $clue['q'] = $userDetails->getQuestionOrder()[0];
      // $clue['q'] = 'b';
      echo json_encode($clue);
    }
    else if($path == $YAPAHUWA)
    {
      if($userDetails->getHashForStep(1) == $anchor)
      {
        $clue['c'] = getClueContent($userDetails->getQuestionOrder()[1], $DAMBADENIYA, $userDetails->getHashForStep(2));
        $clue['q'] = $userDetails->getQuestionOrder()[1];
        
        echo json_encode($clue);
      }
      else
      {
        $clue['c'] = "Time machine misconfigured!";
        $clue['q'] = $userDetails->getQuestionOrder()[1];
        $clue['status'] = "key";
        echo json_encode($clue);
      }
    } 
    else if($path == $DAMBADENIYA) 
    {
      if($userDetails->getHashForStep(2) == $anchor)
      {
        $clue['c'] = getClueContent($userDetails->getQuestionOrder()[2], $POLONNARUWA, $userDetails->getHashForStep(3));
        $clue['q'] = $userDetails->getQuestionOrder()[2];
        
        echo json_encode($clue);
      }
      else
      {
        $clue['c'] = "Time machine misconfigured!";
        $clue['q'] = $userDetails->getQuestionOrder()[2];
        $clue['status'] = "key";
        echo json_encode($clue);
      }
    }
    else if($path == $POLONNARUWA) 
    {
      if($userDetails->getHashForStep(3) == $anchor)
      {
        $clue['c'] = getClueContent($userDetails->getQuestionOrder()[3], $ANURADHAPURA, $userDetails->getHashForStep(4));
        $clue['q'] = $userDetails->getQuestionOrder()[3];
        echo json_encode($clue);
      }
      else
      {
        $clue['c'] = "Time machine misconfigured!";
        $clue['q'] = $userDetails->getQuestionOrder()[3];
        $clue['status'] = "key";
        echo json_encode($clue);
      }
    }
    else if($path == $ANURADHAPURA) 
    {
      if($userDetails->getHashForStep(4) == $anchor)
      {
        // echo $userDetails->getHashForStep(5);
        $finalStep = new FinalStep($userDetails->getHashForStep(5));
        //header("Content-Type: image/png");
        //$image = imagecreatefromstring($finalStep->getClues());
        header("Content-Type: image/png");

        echo imagepng($finalStep->getClue(1));
        
      }
      else
      {
        $clue['c'] = "Time machine misconfigured!";
        // $clue['q'] = $userDetails->getQuestionOrder()[2];
        $clue['status'] = "key";
        echo json_encode($clue);
      }
    } else {
      echo '{"status": "ok"}';  //daddy of all misleadings. ;)
    }

    

    function getClueContent($nextQuestionNumber, $nextPath, $hashForNextStep)
    {

      if($nextQuestionNumber == "a")
      {
        //echo "question A requested to show ". $nextPath . "<br/>";
        $question = new QuestionA($nextPath, $hashForNextStep);
        return $question->getClueForPath();
      }
      else if($nextQuestionNumber == "b")
      {
        //echo "question B requested to show ". $nextPath. "<br/>";
        $question = new QuestionB($nextPath, $hashForNextStep);
        return '<img src="data:image/png;base64,'. base64_encode($question->getClueForPath()) .'" />';
      }
      else if($nextQuestionNumber == "c")
      {
        // echo "question C requested to show ". $nextPath. "<br/>";
        $question = new QuestionC($nextPath, $hashForNextStep);
        return $question->getClueForPath();
      }
      else if($nextQuestionNumber == "d")
      {
        // echo "question D requested to show ". $nextPath. "<br/>";
        $question = new QuestionD($nextPath, $hashForNextStep);
        return $question->getClueForPath();
      }
    }


    function checkCodeWithEmail($email, $visitedPath)
    {
      return true;
    }
