<?php
namespace app\components;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\base\Widget;
use yii\data\Pagination;

class CustomPagination  extends \yii\widgets\LinkPager
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        parent::run();
    }

    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        $page++;
        $options = ['class' => 'pagination pagination-sm'];
        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
        }
        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);

            return Html::tag('li', Html::tag('span', $label), $options);
        }
        $linkOptions = $this->linkOptions;
        $linkOptions['id'] = $page;
        $linkOptions['data-page'] = $page;
        $linkOptions['onmouseup']="getContent('$page','32','?page=".$page."')";

        return Html::tag('li', Html::a($label, '#', $linkOptions), $options);
    }
}