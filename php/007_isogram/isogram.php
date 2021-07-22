<?php

/*
* Determine whether a string is an isogram or not
**/
function isIsogram(String $input = '') :Bool
{
	if (empty($input))
	{
		return FALSE;
	}

	// Remove illegal chars
	$input = str_replace(array('-', ' '), '', $input);

	if ((float) phpversion() > 7.4)
	{
		$input_arr = mb_str_split(mb_strtolower($input));
	}
	// Older PHP versions, didn't have multibyte string split
	else
	{
		$input_arr = custom_mb_str_split(mb_strtolower($input));
	}

	$input_arr_value_counts = array_count_values($input_arr);

	return !(max($input_arr_value_counts) > 1);
}

/*
* Multibyte split_string (custom)
* (added with the assumption that this exercism, really wanted to test us on this)
**/
function custom_mb_str_split(String $input = '')
{
	$output_arr = array();
	$input_len = mb_strlen($input) - 1;

	for ($i = 0; $i < $input_len; $i++)
		$output_arr[] = mb_substr($input, $i, 1, 'UTF-8');

	return $output_arr;
}
