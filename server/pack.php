<?php
require_once 'helper.php';

$packs = Helper::loadJSON(FILE_PICKED_DATA);
if (!$packs) {
    Helper::showError('Missing questions file');
}
Helper::toJSON($packs);