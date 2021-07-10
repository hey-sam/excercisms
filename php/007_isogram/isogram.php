<?php

/*
* Determine whether a string is a isogram or not
**/
function isIsogram(String $input = '')
{
	if ((float) phpversion() > 7.4)
		$input_arr = mb_str_split(mb_strtolower($input));
	else
		$input_arr = custom_mb_str_split(mb_strtolower($input));

}

/*
* Multibyte split_string (custom)
* (added with the assumption that this exercism, really wanted to test us on this)
**/
function custom_mb_str_split(String $input = '')
{
	$output_arr = array();
	$input_len = mb_strlen($input);

	for ($i = 0; $i < ($input_len - 1); $i++)
		$output_arr[] = mb_substr($input, $i, 1, 'UTF-8');

	return $output_arr;
}

// isIsogram('duplicates');
isIsogram('Heizölrückstoßabdämpfung');