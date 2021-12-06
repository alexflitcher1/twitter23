<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
$db = require __DIR__ . '/db.php';
return [
    'id' => 'app-frontend',
    'defaultRoute' => 'posts/index',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                'feed' => 'posts/index',
                'me' => 'user/index',
                'profile' => 'user/profile',
                'search' => 'search/index',
                'signup' => 'user/signup',
                'settings' => 'user/settings',
                'login' => 'user/login',
                'notifications' => 'notifications/index',
                'settings-profile' => 'user/settings-profile',
                'edit' => 'posts/edit',
                'subscribers' => 'user/subscribers',
                'suber' => 'user/subscribers',
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'errorHandler' => [
            'errorAction' => 'user/error',
        ],
    ],
    'params' => $params,
];
