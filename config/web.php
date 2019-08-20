<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'layout' => 'template', // загружаем свой шаблон
    'language' => 'ru-RU', // явно указываем язык
    'defaultRoute' => 'site/index', //загружаем нужный контроллер 
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'kyw74m5jZ3D1RrPA6eed2dIMmWMidnVE',
            //изавляемся от web
            'baseURl' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
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
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                //'category/<id:\d+>/page/<page:\d+>' => 'category/view',//конкретное правило в приоретете над общим!             

                'catalog/category/<id:\d+>/page/<page:\d+>' => 'catalog/category',
                'catalog/category/<id:\d+>' => 'catalog/category',
                'catalog/brand/<id:\d+>/page/<page:\d+>' => 'catalog/brand',
                'catalog/brand/<id:\d+>' => 'catalog/brand',
                'catalog/search/page/<page:\d+>' => 'catalog/search',
                'catalog/search' => 'catalog/search',
                '<action:(index|about|contact|login|signup)>' => 'site/<action>', // убираем контроллер Site из строки регуляркой <a>
            ],
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
            //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
            // uncomment the following to add your IP if you are not connecting from localhost.
            //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
