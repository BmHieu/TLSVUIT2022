<?php
$configData = json_decode(file_get_contents('server/data/config.json'));
$teamData = json_decode(file_get_contents('server/data/team.json'));
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <title>Thủ lĩnh Sinh viên UIT 2022</title>
    <link rel="stylesheet" href="assets/css/style.css"/>
    <link rel="stylesheet" href="assets/css/hexagon.css"/>
	<link rel="icon" type="image/x-icon" href="assets/images/Logo-Leader_Green.png">
</head>
<body>
<img src="./assets/images/hope-star.gif" class="hope-star" />
<div class="question-box-picker">
    <ul class="hexagon-grid-container">
        <li class="hexagon hexagon-green" onclick="Main.pickQuestion(this)">
            <div class="hexagon-inner">
                <span class="hexagon-box-number">20</span>
                <span class="hexagon-featured-score">1</span>
            </div>
        </li>
    </ul>
</div>
<div id="contest"  style="display: none">

    <div id="countdown" class="countdown">0</div>
    <div id="wrapper">
        <div id="content">
            <ul class="question-list">
            </ul>
            <div class="question-box">
                <div id="question-content" class="question-content">
                    <h3 class="question-number"></h3>
                    <div class="question">
                    </div>
                    <ol class="answers" type="A">
                    </ol>
                </div>
                <div id="startup">
                    <div class="startup-message">
                        BẮT ĐẦU
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="result-box">
        <ul id="result-list">
            <li class="default">
                <span class="team-name"></span>
                <span class="score"></span>
            </li>
            <li class="default">
                <span class="team-name"></span>
                <span class="score"></span>
            </li>
            <li class="default">
                <span class="team-name"></span>
                <span class="score"></span>
            </li>
            <li class="default">
                <span class="team-name"></span>
                <span class="score"></span>
            </li>
            <li class="default">
                <span class="team-name"></span>
                <span class="score"></span>
            </li>
        </ul>
    </div>
</div>

<div id="footer">
    <ul class="score-board">
        <li>
            <div class="polygon doia">
                <span></span>
            </div>

            <div id="score-doia" class="score">0</div>
        </li>
        <li>
            <div class="polygon doib">
                <span></span>
            </div>

            <div id="score-doib" class="score">0</div>
        </li>
        <li>
            <div class="polygon doic">
                <span></span>
            </div>

            <div id="score-doic" class="score">0</div>
        </li>
        <li>
            <div class="polygon doid">
                <span></span>
            </div>

            <div id="score-doid" class="score">0</div>
        </li>
        <li>
            <div class="polygon doie">
                <span></span>
            </div>

            <div id="score-doie" class="score">0</div>
        </li>

    </ul>
    <ul class="listname">
        <li>
            <div class="team-name doia"><?php echo $teamData->doia->ten ?></div>
        </li>
        <li>
            <div class="team-name doib"><?php echo $teamData->doib->ten ?></div>
        </li>
        <li>
            <div class="team-name doic"><?php echo $teamData->doic->ten ?></div>
        </li>
        <li>
            <div class="team-name doid"><?php echo $teamData->doid->ten ?></div>
        </li>
        <li>
            <div class="team-name doie"><?php echo $teamData->doie->ten ?></div>
        </li>
    </ul>
</div>
<script src="assets/js/jquery-2.2.4.min.js"></script>
<script src="assets/js/main.js"></script>
<script>
    Main.init();
    Main.DEFAULT_COUNTER = <?php echo $configData->countdown.';'; ?>
    Main.scoreRanges = <?php
            echo '[';
    end($configData->scoreRange);
    $lastKey = key($configData->scoreRange);
    foreach ($configData->scoreRange as $key => $value) {
        echo $value;
        if ($key !== $lastKey) echo ',';
    }
    echo '];'
    ?>
</script>
</body>
</html>