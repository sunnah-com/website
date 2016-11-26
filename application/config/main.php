<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

function _joinpath($dir1, $dir2) {
    return realpath($dir1 . '/' . $dir2);
}

$homePath      = dirname(__FILE__) . '/../..';
$protectedPath = _joinpath($homePath, 'application');
$webrootPath   = _joinpath($homePath, 'public');
$runtimePath   = _joinpath($homePath, 'runtime');

return array(
	'basePath'=>$protectedPath,
	'runtimePath' => $runtimePath,
	'name'=>'Sunnah.com',
	'defaultController' => 'default/index',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.default.models.Util',
	),

	'modules'=>array(
		'default',
		'back',
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'NotInRepo',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1', '72.33.*', '24.183.96.*'),
		),
		
	),

	// application components
	'components'=>array(
		'widgetFactory' => array (
			'widgets' => array (
				'CLinkPager' => array (
					'cssFile' => '/css/pager.css',
				)
			)
		),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'cache' => array(
			'class' => 'CMemCache',
			'useMemcached' => false,
			'servers' => array(
				array('host' => 'localhost', 'port' => 7630),
			),
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				// '(.*)' => 'default/index/maint',
				'' => 'default/index',
				'about' => 'default/index/about',
				'news' => 'default/index/news',
				'changelog' => 'default/index/changelog',
				'support' => 'default/index/support',
				'searchtips' => 'default/index/searchtips',
				'tce' => 'default/collection/tce',
				'ramadan' => 'default/collection/ramadan',
				'socialmedia' => 'default/collection/socialmedia',
				'urn/<urn:\d+>' => 'default/collection/urn',

				'ajax/<lang:\w+>/<collection>/<ourBookID>' => 'default/collection/ajaxHadith/collectionName/<collection>/ourBookID/<ourBookID>/lang/<lang>',

				// Gii
                'gii'=>'gii',
                'gii/<controller:\w+>'=>'gii/<controller>',
                'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',

				'back'=>'back',
				'back/<controller:\w+>'=>'back/<controller>',
				'back/<controller:\w+>/<action:\w+>'=>'back/<controller>/<action>',

				'nawawi40/<hadithNumbers:\d+>' => array('default/collection/dispbook/collectionName/nawawi40/ourBookID/1/hadithNumbers/<hadithNumbers>', 'defaultParams' => array('_escaped_fragment_' => 'default')),
				'nawawi40' => array('default/collection/dispbook/collectionName/nawawi40/ourBookID/1', 'defaultParams' => array('_escaped_fragment_' => 'default')),
				'qudsi40/<hadithNumbers:\d+>' => array('default/collection/dispbook/collectionName/qudsi40/ourBookID/1/hadithNumbers/<hadithNumbers>', 'defaultParams' => array('_escaped_fragment_' => 'default')),
				'qudsi40' => array('default/collection/dispbook/collectionName/qudsi40/ourBookID/1', 'defaultParams' => array('_escaped_fragment_' => 'default')),
		
				'search/<query>/<page:\d+>' => 'default/search/oldsearch',
				'search/<query>' => 'default/search/oldsearch',
				'search/' => 'default/search/search',
				'advanced' => 'default/search/advanced',

				'yiiadmin/flushcache' => 'default/index/flushcache',

				'nasai/35b/<hadithNumbers>' => array('default/collection/dispbook/collectionName/nasai/ourBookID/-35', 'defaultParams' => array('_escaped_fragment_' => 'default')),
				'<collectionName:\w+>/introduction/<hadithNumbers>' => array('default/collection/dispbook/ourBookID/-1', 'defaultParams' => array('_escaped_fragment_' => 'default')),
				'<collectionName:\w+>/<ourBookID:\d+>/<hadithNumbers>' => array('default/collection/dispbook', 'defaultParams' => array('_escaped_fragment_' => 'default')),
				'<collectionName:\w+>/about' => 'default/collection/about',
				'muslim/introduction' => array('default/collection/dispbook/collectionName/muslim/ourBookID/-1', 'defaultParams' => array('_escaped_fragment_' => 'default')),
				'ibnmajah/introduction' => array('default/collection/dispbook/collectionName/ibnmajah/ourBookID/-1', 'defaultParams' => array('_escaped_fragment_' => 'default')),
				'abudawud/letter' => array('default/collection/about/collectionName/abudawud/splpage/adletter', 'defaultParams' => array('_escaped_fragment_' => 'default')),
				'nasai/35b' => array('default/collection/dispbook/collectionName/nasai/ourBookID/-35', 'defaultParams' => array('_escaped_fragment_' => 'default')),
				'<collectionName:\w+>/index' => 'default/collection/colindex',
				'<collectionName:\w+>/<ourBookID:\d+>' => array('default/collection/dispbook', 'defaultParams' => array('_escaped_fragment_' => 'default')),
				'<collectionName:\w+>' => 'default/collection/index',
		
				//'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				//'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				//'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',

				//'<controller>/<action:\w+>'=>'default/<controller>/<action>',
                //'<controller>'=>'default/<controller>',
			),
		),
		
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/
		// uncomment the following to use a MySQL database
		// TODO: Migrate credentials over to a secret handler/KMS
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=hadithdb',
			'schemaCachingDuration' => 300,
			'emulatePrepare' => true,
			'username' => parse_ini_file('config.ini')['db_username'],
			'password' => parse_ini_file('config.ini')['db_password'],
			'charset' => 'utf8',
		),
		'db_internal'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=ilmfruit_testhadithdb',
			'schemaCachingDuration' => 300,
			'class' => 'CDbConnection',
			'emulatePrepare' => true,
			'username' => 'ilmfruit_ansari',
			'password' => 'NotInRepo',
			'charset' => 'utf8',
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				
				array(
					'class'=>'CWebLogRoute',
					'enabled' => YII_DEBUG,
				),
				
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'sunnah@iman.net',
		'cacheTTL' => 7200, // time to leave objects in cache
		'pageSize' => 100,
	),
);
