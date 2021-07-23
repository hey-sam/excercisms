<?php
/**
 * Class Robot
 * Generates a random & unique name/identifier in the format Alpha-Alpha-Num-Num-Num
 *
 * @package		Exercism PHP track
 * @author		hey-sam
 *
 */
class Robot 
{
	private $name = NULL;
	private $used_names = [];

	public function getName() : string
	{
		$this->name = $this->name ?? $this->generateName();
		return $this->name;
	}

	public function reset() : void
	{
		$this->name = NULL;
	}

	private function generateName() :  string
	{
		// $i = 0;
		do 
		{
			$ran_string = randString(2);
			$ran_num = rand(100, 999);

			$rand_name = $ran_string . $ran_num;
			// echo $rand_name . '; Loop: ' . (int) (in_array($rand_name, $this->used_names)) . PHP_EOL;
			// $i++;
		} while (in_array($rand_name, $this->used_names));// && $i < 5);
		
		$this->used_names[] = $rand_name;

		return $rand_name;
	}
}

// Helper function
if (!function_exists('randString'))
{
    function randString(Int $str_length = 2) : string
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    
	    $characters_arr = str_split($characters);
	    shuffle($characters_arr);

	    $characters_arr = array_slice($characters_arr, 0, $str_length); 
	    
	    return implode('', $characters_arr);
    }
}

// $robot = new Robot();
// echo $robot->getName() . PHP_EOL;