<?php
/**
 * Add 10^9 secs to a date
 *
 * @param  DateTime $in_date
 * @param  DateTime $add_secs
 *         
 * @return DateTime $out_date
 */
function from(DateTime $in_date, int $add_secs = 1000000000) {
    $out_date = clone $in_date;
    
    //modify method didn't work as it modifed timestamp, which is only 32bit
    $out_date->add( DateInterval::createFromDateString('+' . $add_secs . ' seconds') );

    return $out_date;
}
