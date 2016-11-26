<?php

$stageParameters = parse_ini_file("stage");
if ($stageParameters && array_key_exists('stage', $stageParameters)) {
    $stage = $stageParameters['stage'];
}
else {
    $stage = "development";
}

$parameters = parse_ini_file("config", true)[$stage];
$credentials = parse_ini_file($parameters['credentialsFile']);
?>
