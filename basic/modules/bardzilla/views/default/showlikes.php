<table align='center' class='lesson' >

    <div id="player">
        <p>
        <div id="count_" ></div>
        <div id="nr_<?= $article->id ?>)" title="Щёлкни, если Нравится" style="cursor: pointer;">
            <img src="<?=$this->theme->getUrl('Img/nrav.ico')?>" width="90" height="15" /> </a></div>
        </p>
        <a href="<?= $article->body ?>" target="_blank"><?php echo $id = $article->id . " - " . $article->minititle ?> </a>

        <audio controls="controls" style="padding-top: 7px;">

            <source src='<?=$this->theme->getUrl($article->body)?>' type='audio/mpeg'>
        </audio>
    </div>


</table>