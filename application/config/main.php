<?php

use \yii\web\UrlNormalizer;

/* Include debug functions */
require_once(__DIR__.'/functions.php');

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

define('TRUE', true);
define('FALSE', false);

$parameters = parse_ini_file(__DIR__ ."/../../.env.local");
if (array_key_exists("showCarousel", $parameters)) {
    $params['showCarousel'] = $parameters['showCarousel'];
}

function _joinpath($dir1, $dir2) {
    return realpath($dir1 . '/' . $dir2);
}

$homePath      = dirname(__FILE__) . '/../../';
$protectedPath = $homePath;
$runtimePath   = _joinpath($homePath, 'runtime');
$vendorPath = _joinpath($parameters['yiiPath'], 'vendor');

$config = [
    'id' => 'sunnah-front',
	'name' => "Sunnah.com website",
    'basePath' => dirname(__DIR__),
	'runtimePath' => $runtimePath,
	'vendorPath' => $vendorPath,
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],

    'defaultRoute' => 'front/index',
    // 'catchAll' => ['front/index/maint'],

    'modules' => [
        'front' => [
            'class' => 'app\modules\front\Front'
        ],
    ],

    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => $parameters['cookieValidationKey'],
			'csrfParam' => '_csrf_frontend',
        ],
        'reCaptcha3' => [
            'class'      => 'kekaadrenalin\recaptcha3\ReCaptcha',
            'site_key'   => $parameters['recaptcha_v3_site_key'],
            'secret_key' => $parameters['recaptcha_v3_secret_key'],
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
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => $parameters['smtpServer'],  // e.g. smtp.mandrillapp.com or smtp.gmail.com
                'username' => $parameters['smtpUser'],
                'password' => $parameters['smtpPassword'],
                'port' => $parameters['smtpPort'], // Port 25 is a very common port too
                'encryption' => 'tls', // It is often used, check your provider or mail server specs
         ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
					'except' => ['yii\web\HttpException:404'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
					'categories' => ['yii\web\HttpException:404'],
					'logFile' => '@runtime/logs/404.log',
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
        // Write DB
        'searchdb' => [
          'class' => 'yii\db\Connection',
          'dsn' => "mysql:host={$parameters['searchdb_host']};dbname={$parameters['searchdb_name']}",
          'username' => $parameters['searchdb_username'],
          'password' => $parameters['searchdb_password'],
          'charset' => 'utf8',
        ],
        'elastic' => [
          'class' => 'app\components\search\engines\ElasticConnection',
          'host' => $parameters['elastic_host'],
          'port' => $parameters['elastic_port'],
          'username' => $parameters['solr_username'],
          'password' => $parameters['solr_password'],
        ],
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
                'donate' => 'front/index/donate',
                'developers' => 'front/index/developers',
                'contact' => 'front/index/contact',
                'searchtips' => 'front/index/search-tips',
                'tce' => 'front/collection/tce',
                '<selection:ramadan>' => 'front/collection/selection',
                '<selection:dhulhijjah>' => 'front/collection/selection',
                '<selection:ashura>' => 'front/collection/selection',
                'selectiondata/<selection:\w+>' => 'front/collection/selection-data', 
                'socialmedia' => 'front/collection/socialmedia',
                'captcha' => 'front/index/captcha',
                'urn/<urn:\d+>' => 'front/collection/urn',
                'narrator/<nid:\d+>' => 'front/narrator/index',

                [ 'pattern' => 'nawawi40:<hadithNumbers:\d+>',
                  'route' => 'front/collection/dispbook', 
                  'defaults' => array('collectionName' => 'forty', 'ourBookID' => 1, '_escaped_fragment_' => 'default'),
                ],
                [ 'pattern' => 'nawawi40/<hadithNumbers:\d+>',
                  'route' => 'front/collection/dispbook', 
                  'defaults' => array('collectionName' => 'forty', 'ourBookID' => 1, '_escaped_fragment_' => 'default'),
                ],
                [ 'pattern' => 'nawawi40',
                  'route' => 'front/collection/dispbook',
                  'defaults' => array('collectionName' => 'forty', 'ourBookID' => 1, '_escaped_fragment_' => 'default'),
                ],
                [ 'pattern' => 'qudsi40:<hadithNumbers:\d+>',
                  'route' => 'front/collection/dispbook', 
                  'defaults' => array('collectionName' => 'forty', 'ourBookID' => 2, '_escaped_fragment_' => 'default'),
                ],
                [ 'pattern' => 'qudsi40/<hadithNumbers:\d+>',
                  'route' => 'front/collection/dispbook', 
                  'defaults' => array('collectionName' => 'forty', 'ourBookID' => 2, '_escaped_fragment_' => 'default'),
                ],
                [ 'pattern' => 'qudsi40',
                  'route' => 'front/collection/dispbook',
                  'defaults' => array('collectionName' => 'forty', 'ourBookID' => 2, '_escaped_fragment_' => 'default'),
                ],
                [ 'pattern' => 'shahwaliullah40:<hadithNumbers:\d+>',
                  'route' => 'front/collection/dispbook', 
                  'defaults' => array('collectionName' => 'forty', 'ourBookID' => 3, '_escaped_fragment_' => 'default'),
                ],
                [ 'pattern' => 'shahwaliullah40/<hadithNumbers:\d+>',
                  'route' => 'front/collection/dispbook', 
                  'defaults' => array('collectionName' => 'forty', 'ourBookID' => 3, '_escaped_fragment_' => 'default'),
                ],
                [ 'pattern' => 'shahwaliullah40',
                  'route' => 'front/collection/dispbook',
                  'defaults' => array('collectionName' => 'forty', 'ourBookID' => 3, '_escaped_fragment_' => 'default'),
                ],
                
                '<collectionName:\w+>:<hadithNumber:\w+>' => 'front/collection/hadith-by-number',
                '<collectionName:\w+>:<hadithNumber1:\w+>-<hadithNumber2:\w+>' => 'front/collection/hadith-by-number-range',

				'ajax/log/hadithcount' => 'front/index/ajaxhadithcount',

                [ 'pattern' => 'ajax/<lang:\w+>/<collectionName>/<ourBookID>',
                  'route' => 'front/collection/ajax-hadith',
                ],

                [ 'pattern' => '<collectionName:hisn>/<hadithNumbers:\d+>',
                  'route' => 'front/collection/dispbook', 
                  'defaults' => array('ourBookID' => 1, '_escaped_fragment_' => 'default'),
                ],
                [ 'pattern' => '<collectionName:hisn>',
                  'route' => 'front/collection/dispbook', 
                  'defaults' => array('ourBookID' => 1, '_escaped_fragment_' => 'default'),
                ],

                [ 'pattern' => '<collectionName:virtues>/<hadithNumbers:\d+>',
                  'route' => 'front/collection/dispbook', 
                  'defaults' => array('ourBookID' => 1, '_escaped_fragment_' => 'default'),
                ],
                [ 'pattern' => '<collectionName:virtues>',
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
                [ 'pattern' => '<collectionName:shamail>/8b/<hadithNumbers>',
                  'route' => 'front/collection/dispbook', 
                  'defaults' => array('ourBookID' => -8, '_escaped_fragment_' => 'default'),
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
                [ 'pattern' => '<collectionName:shamail>/8b',
                  'route' => 'front/collection/dispbook', 
                  'defaults' => array('ourBookID' => -8, '_escaped_fragment_' => 'default'),
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
        // 'allowedIPs' => ['*'],
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
