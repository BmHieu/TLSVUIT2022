<?php
require_once 'helper.php';

$answers = Helper::loadAllTeamAnswers();

Helper::toJSON($answers);