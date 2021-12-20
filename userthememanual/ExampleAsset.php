<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class GreenAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/reset.css', // вы можете создать свой сброс стилей
        'css/{theme}.css',
    ];
    public $js = [
        'js/index.js',
    ];
    public $depends = [
    ];
}

