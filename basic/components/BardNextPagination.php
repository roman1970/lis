<?php
namespace app\components;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\base\Widget;
use yii\data\Pagination;

class BardNextPagination  extends \yii\widgets\LinkPager
{
    public $cat;

    public $nextPageLabel = 'ЕЩЁ!';

    public $prevPageLabel = 'НАЗАД';

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        parent::run();
    }


    protected function renderPageButtons()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }

        $buttons = [];
        $currentPage = $this->pagination->getPage();



        // prev page
        if ($this->prevPageLabel !== false) {
            if (($page = $currentPage - 1) < 0) {
                $page = 0;
            }
            $buttons[] = $this->renderPageButton($this->prevPageLabel, $page, $this->prevPageCssClass, $currentPage <= 0, false);
        }



        // next page
        if ($this->nextPageLabel !== false) {
            if (($page = $currentPage + 1) >= $pageCount - 1) {
                $page = $pageCount - 1;
            }
            $buttons[] = $this->renderPageButton($this->nextPageLabel, $page, $this->nextPageCssClass, $currentPage >= $pageCount - 1, false);
        }



        return Html::tag('ul', implode("\n", $buttons), $this->options);
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
        $linkOptions['onmouseup']="getContent('$page','$this->cat','?page=".$page."')";

        return Html::tag('li', Html::a($label, '#', $linkOptions), $options);
    }
}