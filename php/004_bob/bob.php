<?php
/**
 * Class Bob
 */
//OOP ideas: https://exercism.io/tracks/php/exercises/hamming/solutions/70cda24e541246bbb5230386dd6741b0
class Bob {
    private $ques_and_ans = array();
    
    public function __construct(array $user_ques_and_ans = []) {
        if ( !empty($user_ques_and_ans) ) {
            $this->ques_and_ans = $user_ques_and_ans;
            return;
        }
        
        $this->ques_and_ans[] = ['ques' => 'Default.', 'ans' => 'Whatever.'];
        $this->ques_and_ans[] = ['ques' => 'WATCH OUT!', 'ans' => 'Whoa, chill out!'];
        
        $this->ques_and_ans[] = ['ques' => 'ÜMLÄÜTS!', 'ans' => 'Whoa, chill out!'];
        
        $this->validateText(array_column($this->ques_and_ans, 'ques'));
        $this->validateText(array_column($this->ques_and_ans, 'ans'));
    }
    
    /**
     * Validate and Clean
     *
     * @param  string/array $textxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxis there official way to rep arrayxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
     *
     * @throws InvalidArgumentException
     */    
    private function validateText($text) {
        /****
         * Need to var cleaner too. Maybe as a seperate fcn...
        ****/
        $validateAlpha = function(string $str_text) {
            if ( empty($str_text) || !is_string($str_text) ) {
                throw new InvalidArgumentException ('Bad input  '.$str_text);
            }
        };
        
        if ( gettype($text) === 'string' ) {
            $validateAlpha($text);
        }
        
        //loop through array
        foreach ( $text as $key => $val ) {
            if ( gettype($val) !== 'string' ) {
                throw new InvalidArgumentException ('Invalid input format');
            }            
            
            $validateAlpha($val);
        }
    }
    
    /**
     * Look up corresponding response to question in $this->ques_and_ans
     *
     * @param  string $question
     *
     * @return string $response
     */    
    private function lookupResp(string $question) {
        if ( false !==  ( $respKey = array_search($question, array_column($this->ques_and_ans, 'ques')) ) ) {
            //echo 'in-if: '.$this->ques_and_ans[$respKey]['ans'];
            return $this->ques_and_ans[$respKey]['ans'];
        }
        
        //echo 'out-if: '.$this->ques_and_ans[$respKey]['ans'];
        return $this->ques_and_ans[0]['ans']; //default answer
    }
    
    /**
     * Validate question and respond
     *
     * @param  string $question
     *
     * @return string $response
     */    
    public function respondTo(string $question) {
        //$this->validateText($question);
        
        return $this->lookupResp($question);
    }
}
