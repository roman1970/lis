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
        //'css/styl_rad.css',
        //'js/jQuery-autoComplete-master/jquery.auto-complete.css',
        'css/all-25d7dc7c1a7620d7e82fe3d6412585bb.css'

    ];
    public $js = [
        //'js/main.js',
        //'js/jquery.autocomplete.js',
       // 'js/all-9a817bdc2fe0defd1926c8c6d917d06c.js',
       // 'js/jQuery-autoComplete-master/jquery.auto-complete.min.js',
        //'https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'
       // 'js/autocomplete-0.3.0.js',
        //'js/acomp_script.js',

    ];
    // public $images = [
    //     'images/bg/1.jpg'
    // ];

    public $depends = [
       // 'yii\web\YiiAsset',
       // 'yii\bootstrap\BootstrapAsset',
    ];

    public $jsOptions = [
        'position' => \yii\web\View::POS_BEGIN,
        //'async' => 'async'
    ];



}