

    <div id="player">
        <p>
        <div id="count_" ></div>
        <div id="nr_<?= $article->id ?>)" title="Щёлкни, если Нравится" style="cursor: pointer;">
            <img src="<?=$this->theme->getUrl('Img/nrav.ico')?>" width="90" height="15" /> </a></div>
        </p>

        <a href="<?= $article->audio ?>" target="_blank"><?php echo " --- " . $article->minititle ?> </a>

        <audio controls="controls" ">

            <source src='<?=$article->audio?>' type='audio/mpeg'>
        </audio>

    </div>


