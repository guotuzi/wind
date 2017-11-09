<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
//        'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',    // 这个不能注释，因为username 和 password 不为空，需要这个类；
        'yii\bootstrap\BootstrapAsset',
    ];
}
