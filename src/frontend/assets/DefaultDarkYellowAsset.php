<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class DefaultDarkYellowAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css',
        'css/yellow_dark.css',
    ];
    public $js = [
        'js/index.js',
    ];
    public $depends = [
    ];
}
