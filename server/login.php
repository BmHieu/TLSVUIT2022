<?php
require_once 'helper.php';

if (!isset($_POST['username']) || !isset($_POST['password'])) {
	Helper::showError('Thiếu thông tin đăng nhập');
}

$username = $_POST['username'];
$password = $_POST['password'];

$teamData = Helper::loadTeamData();

if (!isset($teamData[$username])) {
	Helper::showError('Tên đăng nhập không đúng');
}
$user = $teamData[$username];
if ($user['matkhau'] != $password) {
	Helper::showError('Sai mật khẩu');
}

$user = array(
	'username' => $username,
	'fullname' => $teamData[$username]['ten']
);

Helper::setUserData($user);
Helper::toJSON($user);