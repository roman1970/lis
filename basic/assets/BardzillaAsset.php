<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BardzillaAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/themes/bardzilla';
    //public $sourcePath = '@a';


    public $css = [
        'css/styless.css',
       
    ];
    public $js = [
        'js/photos.js',
        'js/jquery.min.js',
        'js/phrase.js',
        'js/phot_left.js',
        'js/theat.js',
        'js/stihi.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
