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
        'js/jQuery-autoComplete-master/jquery.auto-complete.css'

    ];
    public $js = [
        'js/comments.js',
        'js/jquery-cookie/jquery.cookie.js',
        'js/jQuery-autoComplete-master/jquery.auto-complete.min.js'

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',

    ];
}