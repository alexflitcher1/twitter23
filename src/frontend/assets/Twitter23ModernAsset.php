<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class Twitter23ModernAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/twitter23modern.css',
        'css/reset.css',
        'https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap',
        'https://fonts.googleapis.com/css2?family=Source+Code+Pro:wght@600&display=swap'
    ];
    public $js = [
        'js/index.js',
    ];
    public $depends = [
    ];
}
