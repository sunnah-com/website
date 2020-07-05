<?php

use \yii\web\UrlNormalizer;

/* Include debug functions */
require_once(__DIR__.'/functions.php');

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

define('TRUE', true);
define('FALSE', false);

include("loadStageConfig.php");

function _joinpath($dir1, $dir2) {
    return realpath($dir1 . '/' . $dir2);
}

$homePath      = dirname(__FILE__) . '/../../';
$protectedPath = $homePath;
$runtimePath   = _joinpath($homePath, 'runtime');
$vendorPath = _joinpath($parameters['yiiPath'], 'vendor');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
	'runtimePath' => $runtimePath,
	'vendorPath' => $vendorPath,
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],

    'defaultRoute' => 'front/index',

    'modules' => [
        'front' => [
            'class' => 'app\modules\front\Front'
        ],
    ],

    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'ZZVnebTQY6SwqiKZhL7eXCkl-7bSAQyX',
        ],
        'cache' => [
            'class' => 'yii\caching\DummyCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'front/index/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
					'categories' => ['hadithcount'],
					'logFile' => '@runtime/logs/hadithcount.log',
					'logVars' => [],
                ],
            ],
        ],
        'db' => $db,
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
			'normalizer' => [
        		'class' => 'yii\web\UrlNormalizer',
        		// use temporary redirection instead of permanent for debugging
        		'action' => UrlNormalizer::ACTION_REDIRECT_TEMPORARY,
    		],
            'rules' => array(
                // '(.*)' => 'front/index/maint',
                '' => 'front/index',
                'about' => 'front/index/about',
                'news' => 'front/index/news',
                'changelog' => 'front/index/change-log',
                'support' => 'front/index/support',
                'searchtips' => 'front/index/search-tips',
                'tce' => 'front/collection/tce',
                'ramadan' => 'front/collection/ramadan',
                'socialmedia' => 'front/collection/socialmedia',
                'urn/<urn:\d+>' => 'front/collection/urn',

				'ajax/log/hadithcount' => 'front/index/ajaxhadithcount',

                [ 'pattern' => 'ajax/<lang:\w+>/<collectionName>/<ourBookID>',
                  'route' => 'front/collection/ajax-hadith',
                ],
                [ 'pattern' => '<collectionName:nawawi40>/<hadithNumbers:\d+>',
                  'route' => 'front/collection/dispbook', 
                  'defaults' => array('ourBookID' => 1, '_escaped_fragment_' => 'default'),
                ],
                [ 'pattern' => '<collectionName:nawawi40>',
                  'route' => 'front/collection/dispbook',
                  'defaults' => array('ourBookID' => 1, '_escaped_fragment_' => 'default'),
                ],
                [ 'pattern' => '<collectionName:qudsi40>/<hadithNumbers:\d+>',
                  'route' => 'front/collection/dispbook', 
                  'defaults' => array('ourBookID' => 1, '_escaped_fragment_' => 'default'),
                ],
                [ 'pattern' => '<collectionName:qudsi40>',
                  'route' => 'front/collection/dispbook', 
                  'defaults' => array('ourBookID' => 1, '_escaped_fragment_' => 'default'),
                ],
                [ 'pattern' => '<collectionName:hisn>/<hadithNumbers:\d+>',
                  'route' => 'front/collection/dispbook', 
                  'defaults' => array('ourBookID' => 1, '_escaped_fragment_' => 'default'),
                ],
                [ 'pattern' => '<collectionName:hisn>',
                  'route' => 'front/collection/dispbook', 
                  'defaults' => array('ourBookID' => 1, '_escaped_fragment_' => 'default'),
                ],

                'search/<query>/<page:\d+>' => 'front/search/oldsearch',
                'search/<query>' => 'front/search/oldsearch',
                'search' => 'front/search/search',
                'advanced' => 'front/search/advanced',

                'yiiadmin/flushcache' => 'front/index/flush-cache',

                [ 'pattern' => '<collectionName:nasai>/35b/<hadithNumbers>',
                  'route' => 'front/collection/dispbook', 
                  'defaults' => array('ourBookID' => -35, '_escaped_fragment_' => 'default'),
                ],
                [ 'pattern' => '<collectionName:\w+>/introduction/<hadithNumbers>',
                  'route' => 'front/collection/dispbook',
                  'defaults' => array('ourBookID' => -1, '_escaped_fragment_' => 'default'),
                ],
                [ 'pattern' => '<collectionName:\w+>/<ourBookID:\d+>/<hadithNumbers>',
                  'route' => 'front/collection/dispbook', 
                  'defaults' => array('_escaped_fragment_' => 'default'),
                ],
                '<collectionName:\w+>/about' => 'front/collection/about',
                [ 'pattern' => '<collectionName:\w+>/introduction',
                  'route' => 'front/collection/dispbook', 
                  'defaults' => array('ourBookID' => -1, '_escaped_fragment_' => 'default'),
                ],
                [ 'pattern' => '<collectionName:abudawud>/letter',
                  'route' => 'front/collection/about', 
                  'defaults' => array('splpage' => 'adletter', '_escaped_fragment_' => 'default'),
                ],
                [ 'pattern' => '<collectionName:nasai>/35b',
                  'route' => 'front/collection/dispbook', 
                  'defaults' => array('ourBookID' => -35, '_escaped_fragment_' => 'default'),
                ],
                [ 'pattern' => '<collectionName:\w+>/<ourBookID:\d+>',
                  'route' => 'front/collection/dispbook', 
                  'defaults' => array('_escaped_fragment_' => 'default'),
                ],
                '<collectionName:\w+>' => 'front/collection/index',
				'<collectionName:.*>' => 'front/collection/index',
            ),
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}
else {
    $config['components']['cache'] = array(
            'class' => 'yii\caching\MemCache',
            'useMemcached' => TRUE,
            'servers' => array(
                array('host' => $parameters['cacheHost'],
                      'port' => (int) ($parameters['cachePort']),
                     ),
            ),
        );
}

return $config;
