<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],

    // 自己的模块配置
    'modules' => [
        'settings' => [
            'class' => 'backend\modules\settings\Settings',
        ],

        // yii2-grid view 的配置
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ],

    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],

        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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

        // RBAC 权限控制配置
        'authManager' =>
        [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest'],
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        // 收发邮件扩展
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,     //这句一定有，false发送邮件，true只是生成邮件在runtime文件夹下，不发邮件
        ],

        // 创建自己的 component
        'MyComponent' => [
            'class' => 'backend\components\MyComponent'
        ],

        // 模板和js/css 冲突， 单独配置
//        'assetManager' => [
//            'assetMap' => [
//                'bootstrap.js' => '@web/js/bootstrap/js/bootstrap.min.js',
//            ],
//        ],



        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];
