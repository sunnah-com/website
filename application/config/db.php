<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => "mysql:host={$parameters['db_host']};dbname={$parameters['db_name']}",
    'username' => $credentials['db_username'],
    'password' => $credentials['db_password'],
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
