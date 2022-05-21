<?php
require_once 'helper.php';

$data = array(
    'questionBox' => $_POST['questionBox'],
    'questionNum' => $_POST['questionNum']
);
Quizz::removeQuestion($data);
Helper::toJSON($data);


class Quizz {
    public static function loadOneQuestions($box) {
        $filename = sprintf(FILE_QUESTION_PATTERN, $box);
        return Helper::loadJSON($filename);
    }

    public static function removeQuestion($data){
        $box = $data['questionBox'];
        $indexQuestion = $data['questionNum']-1;
        $questions = self::loadOneQuestions($box);
        array_splice($questions, $indexQuestion, 1);
        $filename = sprintf(FILE_QUESTION_PATTERN, $box);
        return Helper::saveJSON($filename, $questions);
    }
}