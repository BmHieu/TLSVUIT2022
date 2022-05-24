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
<ul class="hexagon-grid-container">
    <li class="hexagon hexagon-blue">
        <div class="hexagon-inner">
            <span class="hexagon-box-number">40</span>
            <span class="hexagon-featured-score">1</span>
        </div>
    </li>
    <li class="hexagon hexagon-blue">
        <div class="hexagon-inner">
            <span class="hexagon-box-number">40</span>
            <span class="hexagon-featured-score">2</span>
        </div>
    </li>
    <li class="hexagon hexagon-blue">
        <div class="hexagon-inner">
            <span class="hexagon-box-number">40</span>
            <span class="hexagon-featured-score">3</span>
        </div>
    </li>
    <li class="hexagon hexagon-blue">
        <div class="hexagon-inner">
            <span class="hexagon-box-number">40</span>
            <span class="hexagon-featured-score">4</span>
        </div>
    </li>
    <li class="hexagon hexagon-blue">
        <div class="hexagon-inner">
            <span class="hexagon-box-number">40</span>
            <span class="hexagon-featured-score">5</span>
        </div>
    </li>

    <li class="hexagon hexagon-yellow">
        <div class="hexagon-inner">
            <span class="hexagon-box-number">60</span>
            <span class="hexagon-featured-score">1</span>
        </div>
    </li>
    <li class="hexagon hexagon-yellow">
        <div class="hexagon-inner">
            <span class="hexagon-box-number">60</span>
            <span class="hexagon-featured-score">2</span>
        </div>
    </li>
    <li class="hexagon hexagon-yellow">
        <div class="hexagon-inner">
            <span class="hexagon-box-number">60</span>
            <span class="hexagon-featured-score">3</span>
        </div>
    </li>
    <li class="hexagon hexagon-yellow">
        <div class="hexagon-inner">
            <span class="hexagon-box-number">60</span>
            <span class="hexagon-featured-score">4</span>
        </div>
    </li>
    <li class="hexagon hexagon-yellow">
        <div class="hexagon-inner">
            <span class="hexagon-box-number">60</span>
            <span class="hexagon-featured-score">5</span>
        </div>
    </li>

    <li class="hexagon hexagon-red">
        <div class="hexagon-inner">
            <span class="hexagon-box-number">80</span>
            <span class="hexagon-featured-score">1</span>
        </div>
    </li>
    <li class="hexagon hexagon-red">
        <div class="hexagon-inner">
            <span class="hexagon-box-number">80</span>
            <span class="hexagon-featured-score">2</span>
        </div>
    </li>
    <li class="hexagon hexagon-red">
        <div class="hexagon-inner">
            <span class="hexagon-box-number">80</span>
            <span class="hexagon-featured-score">3</span>
        </div>
    </li>
    <li class="hexagon hexagon-red">
        <div class="hexagon-inner">
            <span class="hexagon-box-number">80</span>
            <span class="hexagon-featured-score">4</span>
        </div>
    </li>
    <li class="hexagon hexagon-red">
        <div class="hexagon-inner">
            <span class="hexagon-box-number">80</span>
            <span class="hexagon-featured-score">5</span>
        </div>
    </li>
</ul>
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