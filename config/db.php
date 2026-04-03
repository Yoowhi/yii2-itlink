<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'postgres:host=' . $_ENV['DB_HOST'] . ';port=' . $_ENV['DB_PORT'] . ';dbname='.$_ENV['DB_NAME'],
    'username' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASSWORD'],
    'charset' => 'utf8',

    'enableSchemaCache' => $_ENV['YII_ENV'] === 'prod',
    'schemaCacheDuration' => 60,
    'schemaCache' => 'cache',
];
