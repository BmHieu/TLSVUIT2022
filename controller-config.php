<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <title>Thủ lĩnh Sinh viên UIT 2019</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/css/controller.css"/>
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand">BẢNG ĐIỀU KHIỂN</a>
            </div>
            <ul class="nav navbar-nav">
                <li><a href="/controller.php">Câu hỏi</a></li>
                <li class="active"><a href="/controller-config.php">Đội thi</a></li>
            </ul>
        </div>
    </nav>
    <div id="content-team">
        <?php
        $teamData = json_decode(file_get_contents('server/data/team.json'));
        $configData = json_decode(file_get_contents('server/data/config.json'));
        foreach ($teamData as $key => $value){
            ?>
            <div class="row mb20">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon">Tài khoản</span>
                        <input id="key" type="text" class="form-control" value="<?php echo $key ?>"
                               aria-describedby="sizing-addon" name="info[keyName]" readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon">Mật khẩu</span>
                        <input id="matkhau" type="text" class="form-control" value="<?php echo $value->matkhau; ?>"
                               aria-describedby="sizing-addon" name="info[<?php echo $key ?>]">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon">Tên chi tiết</span>
                        <input id="ten" type="text" class="form-control" value="<?php echo $value->ten; ?>"
                               aria-describedby="sizing-addon" name="info[<?php echo $key ?>]">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon">Rút gọn</span>
                        <input id="shortName" type="text" class="form-control" value="<?php echo $value->shortName; ?>"
                               aria-describedby="sizing-addon" name="info[<?php echo $key ?>]">
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="row mb20">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon" id="sizing-addon">Thời gian đếm ngược</span>
                    <input id="countdown" type="text" class="form-control" value="<?php echo $configData->countdown; ?>"
                           aria-describedby="sizing-addon" placeholder="Số giây đếm ngược">
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon" id="sizing-addon">Khung điểm</span>
                    <input id="scoreRange" type="text" class="form-control" value="<?php
                    end($configData->scoreRange);
                    $lastKey = key($configData->scoreRange);
                    foreach ($configData->scoreRange as $key => $value) {
                        echo $value;
                        if ($key !== $lastKey) echo '-';
                    }
                    ?>"
                           aria-describedby="sizing-addon" placeholder="Cách nhau bằng dấu -">
                </div>
            </div>
        </div>

        <div class="btn-group">
            <button type="button" onclick="Creator.saveConfig(this);" class="btn btn-submit">Save</button>
        </div>
    </div>

</div>

<script src="assets/js/jquery-2.2.4.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/creator.js?t=<?php echo time(); ?>"></script>
<script>
    Creator.init();
</script>
</body>
</html>