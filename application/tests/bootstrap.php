<?php
    ini_set('error_reporting', E_ALL); // or error_reporting(E_ALL);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');


    require_once(__DIR__.'/../../vendor/yiisoft/yii/framework/yii.php');


include("../config/loadStageConfig.php");

// change the following paths if necessary
$yiit=$parameters['yiiPath'].'/yiit.php';
$config=$parameters['yiiPath'].'/../config/test.php';

require_once($yiit);
require_once(dirname(__FILE__).'/WebTestCase.php');

Yii::createWebApplication($config);
?>
