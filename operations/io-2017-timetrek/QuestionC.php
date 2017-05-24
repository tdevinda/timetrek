<?php
namespace GDGSriLanka\TimeTreck;
/**
  timed question. content will not be revealed until the visit is in the set time
*/
  class QuestionC
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
      $ausHour = 7 + intval($this->hash[0], 16);
      $ausMin = ((intval($this->hash[1], 16) % 6) *10) + (intval($this->hash[0], 16) % 10);
      
      //echo $ausHour. ":" . $ausMin . " ". $this->hash . "<br/>";
      date_default_timezone_set('Asia/Colombo');
      $now = getdate();
      //echo $now['hours'] . " " . $now['minutes'] . "<br/>";
      if($now['minutes'] == $ausMin)
      {
        //you have come at the right time window
        return base64_encode("/". $this->path ."#". $this->hash);
      }
      else
      {
        //come back later at this time
        $clue = "Kalagola and Company. This system has overheated. Falling back to modulated operation. Use at ". base64_encode('AnyHour' .":". sprintf("%02d", $ausMin) .":00");

        return '<p>The time machine is showing an error. But the issue is, the makers of the machine encode their messages. The instruction manual says: "Take N, cut in half, interchange and repeat till end." The manual we got had a note saying N=16,8,4,2 Try if you can make something out of it..</p><br/><p>'. $this->getSwapped($clue) .'</p>';
      }
    }


    private function getSwapped($data)
    {
      $data = str_replace(" ", ".", $data);
      if(strlen($data) % 32 > 0)
      {
        $padLegth = ceil(strlen($data) / 32) * 32;
        $data = str_pad($data, $padLegth, ".", STR_PAD_LEFT);
      }

      //two-letter swap
      for($s = 2;$s < 32;$s *= 2) 
      {
        $swapped = "";
        for($i=0;$i < strlen($data);$i += $s)
        {
          $a = substr($data, $i, ($s / 2));
          $b = substr($data, $i + ($s / 2), ($s / 2));

          $swapped .= ($b . $a);
        }
        $data = $swapped;
        //four letter swap
      }

      return $data;
    }
  }

 ?>
