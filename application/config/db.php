<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => "mysql:host={$parameters['MYSQL_HOST']};dbname={$parameters['MYSQL_DATABASE']}",
    'username' => $parameters['MYSQL_USER'],
    'password' => $parameters['MYSQL_PASSWORD'],
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
