<?php

use app\assets\Russia2018Asset;
use app\components\Helper;
use yii\helpers\Html;
use yii\helpers\Url;

Russia2018Asset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="ru" />

    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>
<?= $content ?>


<?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
