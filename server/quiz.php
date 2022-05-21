<?php

class Quiz {
    public static function answer($username, $answerIndex) {
        $filename = sprintf(FILE_ANSWER_PATTERN, $username);
        $data = array(
            'answer' 	=> $answerIndex,
            'time'		=> microtime(true)
        );
        return Helper::saveJSON($filename, $data);
    }

    public static function loadQuestions() {
        $questionBoxs = array();
        $packs = array(40, 60, 80);
        for ($i = 0; $i < 3; $i++){
            for ($j = 0; $j < 5; $j++){
                $pack = $packs[i];
                $filename = sprintf(FILE_PACK_PATTERN, $pack, $j+1);
                array_push($questionBoxs[$pack], Helper::loadJSON($filename));
            }
        }
        return $questionBoxs;
    }

    public static function loadOneQuestions($pack, $box) {
        $filename = sprintf(FILE_PACK_PATTERN, $pack, $box);
        return Helper::loadJSON($filename);
    }

    public static function getQuestionLength(){
        $questions = self::loadQuestions();
        return count($questions);
    }
}