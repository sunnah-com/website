<?php

$parameters = parse_ini_file(__DIR__ ."/../.env.local");
$stage = $parameters['stage'];

if (strcmp($stage, "prod") != 0) {
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', 'dev');
}

defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require $parameters['yiiPath'] . '/vendor/autoload.php';
require $parameters['yiiPath'] . '/vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../application/config/main.php';

(new yii\web\Application($config))->run();

