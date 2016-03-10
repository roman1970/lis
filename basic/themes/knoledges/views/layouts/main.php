<?php

use app\assets\KnoledgesAsset;
use app\components\Helper;
use yii\helpers\Html;
use yii\helpers\Url;

KnoledgesAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <title>Знания</title>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="<?=$this->theme->getUrl('Img/favicon.ico')?>" tvpe="imaqe/x-icon" />
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,400italic,700&subset=cyrillic-ext,latin' rel='stylesheet' type='text/css' />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

    <script src="<?=$this->theme->getUrl('js/syntaxhighlighter/scripts/shCore.js')?>"></script></body>
    <script src="<?=$this->theme->getUrl('js/syntaxhighlighter/scripts/shBrushPhp.js')?>"></script></body>
    <script src="<?=$this->theme->getUrl('js/syntaxhighlighter/scripts/shBrushBash.js')?>"></script></body>

    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

            <header>
                <div class="container">
                    <div class="logo">
                        <a href="/"><img src="" alt=""></a>
                    </div>
                </div>
            </header>
        <div class="container">
            <?=$content;?>
        </div>
        <footer>
            <div class="container"></div>
        </footer>
<script type="text/javascript">
    SyntaxHighlighter.all()
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
