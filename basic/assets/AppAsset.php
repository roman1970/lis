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
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/flags.css',
        'js/syntaxhighlighter/styles/shCore.css',
        'js/syntaxhighlighter/styles/shThemeDefault.css'
    ];
    public $js = [
        'js/syntaxhighlighter_3.0.83/scripts/shCore.js',
        'js/syntaxhighlighter_3.0.83/scripts/shBrushPhp.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
