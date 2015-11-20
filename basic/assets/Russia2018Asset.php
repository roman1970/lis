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
class Russia2018Asset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/themes/russia2018';
    //public $sourcePath = '@a';
    public $css = [
        'css/styl_rad.css',

    ];
    public $js = [
        'js/main.js'

    ];
    // public $images = [
    //     'images/bg/1.jpg'
    // ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}