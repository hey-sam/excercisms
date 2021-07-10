<?php

/*
* Checks whether an input satisfies the Luhn algorithm
*/
function isValid($input) 
{
    $input = removeWhitespace($input);

    if ( empty($input) )
        return FALSE;
    else if ( gettype($input) !== 'string' && gettype($input) !== 'number' )
        return FALSE;
    else if ( gettype($input) === 'string' && strlen($input) < 2 )
        return FALSE;
    
    $input_length = strlen($input);

    /*  Whether input length is even or odd, tells us which index is the second position
        [1]   2   [3]   4   [5]   6   Even
              1   [2]   3   [4]   5   Odd
                  [1]   2   [3]   4   Even
                        1   [2]   3   Odd
                            [1]   2   Even
    */
    $input_length_parity = $input_length % 2;

    // Start testing input backwards (from the right to the left)
    $checksum = 0;
    for ( $idx = $input_length - 1; $idx >= 0; $idx-- )
    {
        // Non-digit chars are not allowed
        if ( !is_numeric($input[$idx]) )
            return FALSE;

        $curr_num = intval($input[$idx]);

        // Access every second char
        if ( $idx % 2 == $input_length_parity )
        {
            $curr_num = $curr_num * 2;
            $curr_num = ( $curr_num > 9 ) ? $curr_num - 9 : $curr_num;
        }

        $checksum += $curr_num;
    }

    return ( $checksum % 10 ) ? FALSE : TRUE;

}

function removeWhitespace($string) 
{
    return preg_replace("/\s+/", '', $string);
}