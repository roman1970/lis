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
class KnoledgesAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/themes/knoledges';
    //public $sourcePath = '@a';


    public $css = [
        'css/style.css',
        'js/syntaxhighlighter/styles/shCore.css',
        'js/syntaxhighlighter/styles/shThemeDefault.css'

    ];
    public $js = [

    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
