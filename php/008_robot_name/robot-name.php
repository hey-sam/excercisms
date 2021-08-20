<?php
/**
 * Generates a random & unique name/identifier.
 * Identifier consists of letters followed by 3 numbers, e.g. AA999
 *
 * @package		Exercism PHP track
 * @author		hey-sam
 *
 */
class Robot 
{
	private $name = NULL;
	private $used_names;
	protected $persistentStorage;

	public function __construct(Persistance $persistentStorage = NULL)
	{
		$this->persistentStorage = $persistentStorage;
		
		// Exercism test doesn't provide depencency, so manually setting it up
		if (!$this->persistentStorage)
		{
			$this->persistentStorage = new mockPersistantMemory();
		}

		$used_names = $this->persistentStorage->get('used_names');
		if (!$used_names)
		{
			$used_names = [];
			$this->persistentStorage->set('used_names', $used_names);
		}

		$this->used_names = $used_names;
	}

	public function __destruct()
	{
		$this->persistentStorage->set('used_names', $this->used_names);
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

/**
 * An interface to be implemented by any storage dependency
 *
 * @package		Exercism PHP track
 * @author		hey-sam
 *
 */
interface Persistance 
{
	public function setPersistance(&$persistance);
	public function set($key, $data = NULL);
	public function get($key);
}

/**
 * A mock persistant memory, that uses a superglobal, for the purpose of the Exercism test
 *
 * @package		Exercism PHP track
 * @author		hey-sam
 *
 */
class mockPersistantMemory implements Persistance
{
	protected $memory;

	public function __construct($persistance = NULL)
	{
		$persistance = !$persistance 
			? $GLOBALS
			: $persistance; 
		$this->setPersistance($persistance);
	}

	public function setPersistance(&$persistance)
	{
		$this->memory = $persistance;
	}

	public function set($key, $data = NULL)
	{
		$this->memory[$key] = $data;
	}

	public function get($key)
	{
		return !empty($this->memory[$key]) ? $this->memory[$key] : NULL;
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
