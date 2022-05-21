<?php
require_once 'helper.php';

$teamData = $_POST['infoTeam'];
$countdown = $_POST['countdown'];
$scoreRange = $_POST['scoreRange'];

settype($countdown, "int");
$scoreRange = explode("-", $scoreRange);
foreach ($scoreRange as $index => $value) {
    settype($scoreRange[$index], "int");
}

$configData = Helper::loadConfigData();
$configData->countdown = $countdown;
$configData->scoreRange = $scoreRange;

Helper::saveJSON('data/team.json', $teamData);
return var_dump(Helper::saveJSON('data/config.json', $configData));