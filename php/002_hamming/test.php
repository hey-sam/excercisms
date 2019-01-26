<?php
function distance($a, $b) {
    $dna_dis = 0;
    $a_len = 0; //def len of $a, only once
    $times = array();
    
    //validation (and also def $a_len inline here)
    if ( !ctype_alpha($a) || !ctype_alpha($b) ) {
        throw new InvalidArgumentException('One or more of the input was improperly formated. ');
    }
    if ( ( $a_len = strlen($a) ) !== strlen($b) ) {
        throw new InvalidArgumentException('DNA strands must be of equal length.');
    }
    
    //calc dna dis
    $uc_a = strtoupper($a);
    $uc_b = strtoupper($b);
    $times['normal'] = -microtime(true);
    for ($i = 0; $i < 50; $i++) {
        $dna_dis = 0;
        for ($i = 0; $i < $a_len; $i++) {
            if ( $uc_a[$i] == $uc_b[$i] ) continue;
            
            $dna_dis++;
        }
    }
    sleep(1);
    $times['normal'] += microtime(true);
    
    $times['array_diff_assoc'] = -microtime(true);
    for ($i = 0; $i < 50; $i++) {
        $dna_dis = 0;
        $dna_dis = count(array_diff_assoc(str_split($uc_a), str_split($uc_b)));
    }
    sleep(1);
    $times['array_diff_assoc'] += microtime(true);
    
    $out = '';
    foreach ($times as $k => $v) {
        $out .= '<br>'.$k.' took ' .$v.' secs';
    }
    
    return $dna_dis . $out;
}
echo distance('abcmefghijklmnopqrstuvwxyzabcdefghijklmnipqrstuvwxyzabcmefghijklmnopqrstuvwxyzabcdefghijklmnipqrstuvwxyzabcmefghijklmnopqrstuvwxyzabcdefghijklmnipqrstuvwxyzabcmefghijklmnopqrstuvwxyzabcdefghijklmnipqrstuvwxyz', 'abcdefghijylmnopqrstuvwxfzabcdefghijklmtopqrstuvwxyzabcdefghijylmnopqrstuvwxfzabcdefghijklmtopqrstuvwxyzabcdefghijylmnopqrstuvwxfzabcdefghijklmtopqrstuvwxyzabcdefghijylmnopqrstuvwxfzabcdefghijklmtopqrstuvwxyz');