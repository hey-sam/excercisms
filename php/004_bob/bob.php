<?php
/**
 * Class Bob
 * Solves both exercise and Stretch Goals
 *
 * @package		Exercism PHP track
 * @author		hey-sam
 *
 */
class Bob {
    private $ques_type_and_ans = array();
    
    public function __construct(array $user_ques_type_and_ans = []) {
        $this->ques_type_and_ans[] = ['ques_type' => 'Default.', 'ans' => 'Whatever.'];
        
        //use custom defined question types and answers
        if ( !empty($user_ques_type_and_ans) ) {
            $this->ques_type_and_ans = $user_ques_type_and_ans;
            
            return;
        }
        
        //default question types and responses
        $this->ques_type_and_ans[] = ['ques_type' => 'Empty.', 'ans' => 'Fine. Be that way!'];
        $this->ques_type_and_ans[] = ['ques_type' => 'Question and Yelling.', 'ans' => "Calm down, I know what I'm doing!"];
        $this->ques_type_and_ans[] = ['ques_type' => 'Yelling.', 'ans' => 'Whoa, chill out!'];
        $this->ques_type_and_ans[] = ['ques_type' => 'Question.', 'ans' => 'Sure.'];
    }
    
    /**
     * Sanitize user input
     *
     * @param  string $inputText
     *
     * @return string $clean_text
     */
    private function sanitizeText(string $inputText) {
        $clean_text = '';

        if ( isset($inputText) || !empty($inputText) ) { 
            $clean_text = $inputText;

            $clean_text = trim($clean_text);
            $clean_text = stripslashes($clean_text);
            $clean_text = strip_tags($clean_text);
        }

        return $clean_text;
    }
    
    /**
     * Extracts only legal chars (latin chars, ',', '.', '!', '?').
     * '?' is the only thing used to identify a string as a question
     * chars are extracted to identify lower (calm) and upper (yelling) case text
     * Extracting punctuation too, to differentiate between empty/whitespace input => empty and illegal chars => not empty
     *    e.g. "    " => "", therefore input was nothing; "1, 2, 3" => ",,", therefore input was nonsensical
     *
     * @param  string $text
     *
     * @return string anonymous
     */
    private function extractAlphaText(string $text) {
        //https://www.utf8-chartable.de/unicode-utf8-table.pl
        //returns only latin chars and punctuation (replaces whats not in list with '')
        return preg_replace('/[^a-zA-Z\x{00c0}-\x{00d6}\x{00d8}-\x{00f6}\x{00f8}-\x{00ff}\,\.\!\?]/u', '', $text); 
    }  
    
    /**
     * Checks if text is written in all caps
     *
     * @param  string $text
     *
     * @return bool true/false
     */
    private function isAllCaps(string $text) {
        //OBSOLETE. Also Return True for chars with no uppercase such as numbers or punctuation
        //return ($textAlphaOnly && $textAlphaOnly === mb_strtoupper($textAlphaOnly, 'UTF-8')); 
        
        //check for prensence of uppercase chars, and anything else is assumed to be lower case
        //idea https://stackoverflow.com/a/4211896
        //assume ß (00df) is both upper and lower case
        preg_match_all('/\b[A-Z\x{00c0}-\x{00d6}\x{00d8}-\x{00df}]+\b/u', $text, $matches, PREG_SET_ORDER, 0);
        
        return empty( $matches ) ? 0 : 1;
    }
    
    /**
     * Checks if last char in text is a question mark
     *
     * @param  string $text
     *
     * @return bool true/false
     */
    private function isQuestion(string $text) {
        $text_len = mb_strlen($text);
        
        return ( $text_len && $text[$text_len - 1] === '?' );
    }
        
    /**
     * Look up corresponding response to ques_type in ques_type_and_ans
     *
     * @param  string $ques_type
     *
     * @return string $response
     */
    private function lookupResp(string $ques_type) {
        //extract only ques_type coloumn, so that array_search canbe used
        $sub_arr_ques_types = array_column($this->ques_type_and_ans, 'ques_type'); 
        $resp_key = array_search($ques_type, $sub_arr_ques_types);
        
        if ( $resp_key !== false ) {
            return $this->ques_type_and_ans[$resp_key]['ans'];
        }
        
        //default answer
        return $this->ques_type_and_ans[0]['ans'];
    }
    
    /**
     * Validate question, identify type of question (types defined in ques_type_and_ans) and respond
     *
     * @param  string $question
     *
     * @return string $response
     */    
    public function respondTo(string $question) {
        //sanitize the question
        $question_cleaned = $this->sanitizeText($question);
        
        //clean the question
        $question_cleaned = $this->extractAlphaText($question_cleaned);
        
        // none of above applies and clean question is not empty, we want this reply
        if ( empty( str_replace(' ', '', $question) ) ) {
            return $this->lookupResp('Empty.');
        }
        
        //analyze the question
        if ( $this->isAllCaps($question_cleaned) && $this->isQuestion($question_cleaned) ) {
            return $this->lookupResp('Question and Yelling.');
        }
        
        if ( $this->isQuestion($question_cleaned) ) {
            return $this->lookupResp('Question.');
        }
        
        if ( $this->isAllCaps($question_cleaned) ) {
            return $this->lookupResp('Yelling.');
        }
        
        //if none of above applies and clean question is empty, we want this reply
        if ( empty( $question_cleaned ) ) {
            return $this->lookupResp('Empty.');
        }
        
        //if any other question is asked, look up a relevant response. if not found, it will return the response for the 'Default' key
        return $this->lookupResp($question_cleaned);
    }
}
