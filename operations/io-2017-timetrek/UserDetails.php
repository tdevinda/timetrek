<?php

namespace GDGSriLanka\TimeTreck;

class UserDetails
{
  private $email;
  private $questionOrder;


  public function __construct($email)
  {
    $this->email = $email;
    $this->computeQuestionOrderString();

  }

  public function getQuestionOrder()
  {
    return $this->questionOrder;
  }

  public function getHashForStep($step)
  {
    if($step < 5)
    {
      //step defines which step 1 - 4
      $emailHash = $this->gethashForEmail();
      $step = $this->questionOrder[$step - 1];

      $stepHash = md5($emailHash . $step);
      return substr($stepHash, 0, 6);
    } 
    else 
    {
      //hash for final step
      $emailHash = $this->gethashForEmail();
      $finalHash = md5($emailHash. "present-day");

      return substr($finalHash, 0, 8);
    }
  }

  public function printUser()
  {
    return ($this->email ." ". $this->questionOrder[0] .",". $this->questionOrder[1] .",". $this->questionOrder[2] .",". $this->questionOrder[3] ." ". $this->getHashForStep(1) .",". $this->getHashForStep(2) .",". $this->getHashForStep(3) .",". $this->getHashForStep(4) ."<br/>");
  }

  // ----- internals -----

  private function gethashForEmail()
  {
    $fixedHashingString = "io-extended-2017";
    $hash = md5($this->email . $fixedHashingString);
    return $hash;
  }

  private function computeQuestionOrderString()
  {
    $hash = $this->gethashForEmail();
    // echo "hash is ". $hash;
    //we will be looking at an array and select which n'th zero populated element
    //  needs to be filled with the next test type
    $selection = array(0, 0, 0, 0);
    $firstDigit = $hash[0];
    $firstSelectionValue = intval($firstDigit, 16) + 1;
    $firstSelection = ceil($firstSelectionValue / 4);

    $selection = $this->insertAtFreeSlot($selection, $firstSelection, 'a');


    $secondDigit = $hash[1];
    $secondSelectionValue = intval($secondDigit, 16) == 0?1:intval($secondDigit, 16);
    $secondSelection = ceil($secondSelectionValue / 5);

    $selection = $this->insertAtFreeSlot($selection, $secondSelection, 'b');


    $thirdDigit = $hash[2];
    $thirdSelectionValue = intval($thirdDigit, 16) + 1;
    $thirdSelection = ceil($thirdSelectionValue / 8);

    $selection = $this->insertAtFreeSlot($selection, $thirdSelection, 'c');

    //no need to calculate. allocate as free.
    $selection = $this->insertAtFreeSlot($selection, 1, 'd');

    $this->questionOrder = $selection;
    return $selection;
  }


  /**
  Freeslot starts from 1 not zero.
  */
  private function insertAtFreeSlot($slotArray, $freeSlotNumber, $numberToInsert)
  {
    $freeSlots = 0;

    for($i=0;i < count($slotArray);$i++)
    {
      if(strcmp($slotArray[$i], 0) == 0)
      {
        $freeSlots += 1;
      }

      if($freeSlotNumber == $freeSlots)
      {
        // echo "found slot ". $freeSlotNumber ." at ". $i;
        $slotArray[$i] = $numberToInsert;
        return $slotArray;
      }
    }


    return -1;
  }





}


?>
