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
        'js/jQuery-autoComplete-master/jquery.auto-complete.css',
        'css/jquery-ui.css',
        'js/jPlayer-2.9.2/dist/skin/blue.monday/css/jplayer.blue.monday.css',
        'css/flags.css'

    ];
    public $js = [
        'js/comments.js',
        'js/jquery-cookie/jquery.cookie.js',
        'js/jQuery-autoComplete-master/jquery.auto-complete.min.js',
        'js/jquery-ui.js',
        'js/jPlayer-2.9.2/dist/jplayer/jquery.jplayer.min.js',
        'js/jPlayer-2.9.2/src/javascript/add-on/jplayer.playlist.js'

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',

    ];
}