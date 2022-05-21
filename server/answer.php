<?php
require_once 'helper.php';
require_once 'quiz.php';

if (!isset($_POST['answerIndex']) && !isset($_POST['answerStatement'])) {
	Helper::showError('Chưa chọn câu trả lời');
}

$userData = Helper::getUserData();
if (!$userData) {
	Helper::showError('Bạn chưa đăng nhập');
}

if (isset($_POST['answerIndex'])) {
    Quiz::answer($userData['username'], (int)$_POST['answerIndex']);
} else if (isset($_POST['answerStatement'])) {
    Quiz::answer($userData['username'], (string)$_POST['answerStatement']);
}
Helper::toJSON(array(
	'data' => true
));