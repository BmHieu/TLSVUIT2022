<?php
require_once 'helper.php';
require_once 'quiz.php';

$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'GET') {
    $questions = Quiz::loadQuestions();
    if (!$questions) {
        Helper::showError('Missing questions file');
    }
    Helper::toJSON($questions);
} else if ($method === 'POST') {
    $data = array(
        'questionBox' => @$_POST['questionBox'],
        'packIndex' => @$_POST['packIndex']
    );

    $questions = Quiz::loadOneQuestions($data['packIndex'], $data['questionBox']);
    if (!$questions) {
        Helper::showError('Missing questions file');
    }
    return Helper::toJSON($questions);
}