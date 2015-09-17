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
class LandberryAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/themes/landberry';
    //public $sourcePath = '@a';
    public $css = [
        'css/animate.css',
        'css/bootstrap.min.css',
        'css/flexslider.css',
        'css/font-awesome.css',
        'css/index.css',
        'css/owl.carousel.css',
        'css/sonnik_style.css',
        'css/style.css',
        'css/traffic-calc.css'
    ];
    public $js = [
        'js/bootstrap.min.js',
        'js/flexcroll.js',
        'js/flexslider.js',
        'js/jquery.appear.js',
        'js/jquery.backstretch.min.js',
        'js/jquery.countTo.js',
        'js/jquery.min.js',
        'js/jquery.mixitup.min.js',
        'js/jquery.nav.js',
        'js/jquery.validate.js',
        'js/jquery.validation.min.js',
        'js/jsCarousel-2.0.0.js',
        'js/main.js',
        'js/main-dropdown.js',
        'js/owl.carousel.min.js',
        'js/placeholders.js',
        'js/respond.js',
        'js/scripts.js',
        'js/traffic-calc.js',
        'js/traffic-calc-settings.js'
    ];
   // public $images = [
   //     'images/bg/1.jpg'
   // ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}