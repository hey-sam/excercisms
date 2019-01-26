<?php

function distance($a, $b) {
    $dna_dis = 0;
    $a_len = 0; //def len of $a, only once
    
    //validation (and also def $a_len inline here)
    if ( !ctype_alpha($a) || !ctype_alpha($b) ) {
        throw new InvalidArgumentException('One or more of the input was improperly formated. ');
    }
    if ( ( $a_len = strlen($a) ) !== strlen($b) ) {
        throw new InvalidArgumentException('DNA strands must be of equal length.');
    }
    
    //find dna dis
    $uc_a = strtoupper($a);
    $uc_b = strtoupper($b);
    
    //check if they are the same first
    if ( $uc_a == $uc_b ) {
        return 0;
    }
    
    //calc dna dis
    for ($i = 0; $i < $a_len; $i++) {
        if ( $uc_a[$i] == $uc_b[$i] ) continue;
        
        $dna_dis++;
    }
    
    return $dna_dis;
}
