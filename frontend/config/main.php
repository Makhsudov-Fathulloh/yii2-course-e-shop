<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
//    'language' => 'ru-RU',
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'category/index',
    'modules' => [
        'admin' => [
            'class' => 'backend\modules\admin\Module',
            'layout' => 'admin'
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true, // userni eslab qolish
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
//            'loginUrl' => '';
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true, // local send email, real project da false qilishkerak
//            'transport' => [
//                'class' => 'Swift_SmtpTransport',
//                'host' => 'localhost',
//                'username' => 'username',
//                'password' => 'password',
//                'port' => '587',
//                'encryption' => 'tls',
//            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'category/<id:\d+>/page/<page:\d+>' => 'category/view', // category/...?page=... === category/.../page=... 
                'category/<id:\d+>' => 'category/view', // category/view?id=... === category/...
                'product/<id:\d+>' => 'product/view', // product/view?id=... === product/...
            ],
        ],
    ],

    'params' => $params,
];
