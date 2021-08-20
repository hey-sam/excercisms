<?php
/**
 * Class Robot
 * Generates a random & unique name/identifier.
 * Identifier consists of the letters followed by 3 numbers, e.g. AA999
 *
 * @package		Exercism PHP track
 * @author		hey-sam
 *
 */
class Robot 
{
	private $name = NULL;
	private $used_names = [];

	public function __construct()
	{
		// Making use of a superglobal in lieu of a member variable of the parent class
		$GLOBALS['used_names'] = empty($GLOBALS['used_names']) 
			? []
			: $GLOBALS['used_names'];
		$this->used_names = &$GLOBALS['used_names'];
	}

	public function getName($aaa = 0) : string
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
		do 
		{
			$ran_string = randString(2);
			$ran_num = random_int(100, 999);

			$rand_name = $ran_string . $ran_num;
		} while (in_array($rand_name, $this->used_names));
		
		$this->used_names[] = $rand_name;

		return $rand_name;
	}
}

// Helper function
if (!function_exists('randString'))
{
    function randString(int $str_length = 2) : string
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $characters_arr = str_split($characters);
	    shuffle($characters_arr);

	    $characters_arr = array_slice($characters_arr, 0, $str_length); 
	    
	    return implode('', $characters_arr);
    }
}
