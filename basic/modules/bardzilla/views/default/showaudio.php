<script>
    var r = 0;

    function setLike(idLike) {

        $("#count_").load("bardzilla/default/setlikes/"+idLike);
        $("#nr_"+idLike).hide();

    }
    function nextSong(id){
        $("#song").show();
        $("#song").load("bardzilla/default/showlikes/"+id);

        if (!last) {y = document.getElementById("song"); /*Освобождаем #main*/
            var last = y.lastChild;
            last.parentNode.removeChild(last);
        }

        $("#count_").ajaxSuccess(function() { //убираем количество после голосования
            $(this).text(name);
            $(this).hide();

        });

    }

    function showSongs(i){
        $("#songs"+i).show();
    }

    function showBlock(i){
        $("#block"+i).show();
    }

    function getRandom(max,min)
    {
       r = Math.random()* (max - min) + min;
        console.log(random);
    }

    function more(){
        return r++;
    }


</script>
<?php /*
<p class="hd">

    <span onmouseup="getContent('<?=$cat_obg->cssclass?>',  <?=$cat_obg->id?>)">еще</span>

</p>
 */ ?>
<?php if(isset($articles)): $count = count($articles);
    $r = rand(0,$count-1); ?>

    <?php $u =0;/*echo app\components\CustomPagination::widget([
        'pagination' => $artPages,
        'cat' => $cat
    ]);*/
     ?>
    <div class="accord" style="text-align: left">

        <h3 style="text-align: center"><?=$articles[$r]['article']->title?></h3>
            <span>

                <div class='content'>

                    <img src="<?=$articles[$r]['article']->img?>" width="250" height="200" alt="<?=$articles[$r]['article']->title?>"/>
                    <br />

                    <div id="text_main"><?=$articles[$r]['article']->text?><hr />
                        <a onclick="showSongs(<?= $articles[$r]['article']->id ?>)" style="cursor: pointer;">Послушай альбом</a><hr />

                    </div>

                </div>
                <div class="content" id="songs<?= $articles[$r]['article']->id ?>" style="display: none;">
                    <div id="songs_name">
                    <?php if (isset($articles[$r]['contents']))  : ?>
                        <?php $i = 0; ?>

                        <?php foreach ($articles[$r]['contents'] as $cont) :
                            $i++;  ?>
                            <a onclick="nextSong(<?= $cont->id ?>)" style="cursor: pointer;"><?= $i.'-'.$cont->minititle ?></a> ///

                        <?php endforeach; ?>

                    <?php endif; ?>
                    </div>
                </div><br>

                <div id="song" style="display: none;">

                </div><br>
            </span>



    <?php // endforeach; ?>
    </div>

<?php endif; ?>
