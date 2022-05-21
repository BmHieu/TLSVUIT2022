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
                <li class="active"><a href="/controller.php">Câu hỏi</a></li>
                <li><a href="/controller-config.php">Đội thi</a></li>
            </ul>
        </div>
    </nav>
    <div id="content">
        <div class="question-box">
            <div class="row mb20">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon2">Bộ câu hỏi số</span>
                        <input id="questionBoxNumber" type="text" class="form-control" placeholder="1"
                               aria-describedby="sizing-addon2" value="1">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon2">Câu hỏi số</span>
                        <input id="questionNumber" type="text" class="form-control" placeholder="1"
                               aria-describedby="sizing-addon2">
                    </div>
                </div>
            </div>
            <textarea id="question" class="question mb20" name="question" rows="5"
                      placeholder="Nhập câu hỏi..."></textarea>
            <div class="answer">
                <div class="input-group">
                    <span class="input-group-addon">
                        <input type="radio" name="radio_answer" class="subSelector">
                    </span>
                    <input name="answer[]" type="text" class="form-control" placeholder="Đáp án 1">
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <input type="radio" name="radio_answer" class="subSelector">
                    </span>
                    <input name="answer[]" type="text" class="form-control" placeholder="Đáp án 2">
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <input type="radio" name="radio_answer" class="subSelector">
                    </span>
                    <input name="answer[]" type="text" class="form-control" placeholder="Đáp án 3">
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <input type="radio" name="radio_answer" class="subSelector">
                    </span>
                    <input name="answer[]" type="text" class="form-control" placeholder="Đáp án 4">
                </div>
            </div>
            <div class="btn-group">
                <button type="button" onclick="Creator.addQuiz(this);" class="btn btn-submit">Submit</button>
                <button type="button" onclick="Creator.removeQuiz(this);" class="btn btn-remove">Delete</button>
            </div>
        </div>

        <div class="right-menu">
            <div class="panel-group" id="accordion">
            </div>
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