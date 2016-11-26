<?php

include("../application/config/loadStageConfig.php");

// change the following paths if necessary
$yii = $parameters['yiiPath'];
$config=dirname(__FILE__).'/../application/config/main.php';

if (strcmp($stage, "prod") != 0) { 
	defined('YII_DEBUG') or define('YII_DEBUG',true);
}
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
