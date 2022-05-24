<?php
require_once 'server/helper.php';
$userData = Helper::getUserData();
$isLoggedIn = $userData !== false;
$names = array(
	'doia' => 'Ngọc Nga',
	'doib' => 'Thùy Trang',
	'doic' => 'Gia Khang',
	'doid' => 'Thành Thắng',
	'doie' => 'Gia Hiếu',
);
?>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
	<title>Thủ lĩnh sinh viên UIT 2022</title>
	<link rel="stylesheet" href="assets/css/client.css" />
	<link rel="stylesheet" href="assets/css/bootstrap4.min.css" />
	<link rel="icon" type="image/x-icon" href="assets/images/Logo-Leader_Green.png">

</head>
<body>
<div class="header">
	<img onclick="Client.clearSelection();" src="./assets/images/logo.png" class="logo" />
	<?php if ($isLoggedIn) { ?>
	<h2  onclick="Client.showLogs();" class="team-name"><?php echo $names[$userData['username']]; ?></h2>
	<?php } ?>
</div>
<?php if ($isLoggedIn) { ?>
<div class="select-box">
    <div class="input-group mb-2">
        <input type="text" class="form-control"
               placeholder="Đáp án cho câu hỏi tự luận"
               aria-label="answer statement"
               id="statement"
               aria-describedby="basic-addon2">
        <div class="input-group-append">
            <button class="btn btn-info" type="button" onclick="Client.submitStatement();">Gửi</button>
        </div>
    </div>
	<div onclick="Client.selectAnswer(this);" data-text="0" class="select-item">
		<span class="select-a"></span>
	</div>
	<div onclick="Client.selectAnswer(this);" data-text="1" class="select-item">
		<span class="select-b"></span>
	</div>
	<div onclick="Client.selectAnswer(this);" data-text="2" class="select-item">
		<span class="select-c"></span>
	</div>
	<div onclick="Client.selectAnswer(this);" data-text="3" class="select-item">
		<span class="select-d"></span>
	</div>
</div>
<?php } else { ?>
<div class="login">
	<div class="form-control">
		<label for="username">Tên đăng nhập:</label>
		<input type="text" id="username" placeholder="Tên đăng nhập" />
	</div>
	<div class="form-control">
		<label for="password">Mật khẩu:</label>
		<input type="password" id="password" placeholder="Mật khẩu" />
	</div>

	<div class="form-control">
		<button class="btn-login" onclick="Client.login(this);">Đăng nhập</button>
	</div>
</div>
<?php } ?>
<script src="assets/js/jquery-2.2.4.min.js"></script>
<script src="assets/js/client.js"></script>
</body>
</html>