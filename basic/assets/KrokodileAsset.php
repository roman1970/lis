<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class KrokodileAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/themes/krokodile';
    public $css = [
        'css53/style.css', //css css55 тоже ничего

    ];
    public $js = [

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',

    ];
}