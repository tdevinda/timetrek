<?php
  namespace GDGSriLanka\TimeTreck;
class Step_2 
{

	private $clue;

	public function __construct($clue) 
	{
		$this->clue = $clue;
	}
	

	public function getOutput() 
	{
		$primefile = fopen("primes.dat", "r");
		
		$binString = "";
		for($i=0;$i < strlen($this->clue);$i++)
		{
			$binString .= str_pad(decbin(ord(substr($this->clue, $i, 1))), 8, "0", STR_PAD_LEFT);
		}
		// echo $binString;
		$numbers = array();
		for($j=0;$j < strlen($binString);$j++)
		{
			$char = substr($binString, $j, 1);
			if($char == '0')
			{
				$numbers[$j] = rand(234, 278) * rand(2121, 2245);
			}
			else 
			{

				$readahead = rand(10, 100);
				while ($readahead-- > 0) {
					fgets($primefile);
				}

				$numbers[$j] = str_replace('\r', '', str_replace('\n', '', fgets($primefile, 7)));
			}
		}

		fclose($primefile);
		// var_dump($numbers);
		return implode(",", $numbers);

	}

	public function getDescription()
	{
		return "With trade deals going on with europeans, they might have been amazed about our mathematical knowledge. The prime 
		high people in that aincient soceity must have wondered why the low caste were so easily divided";
	}


	
}
?>