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
/*
    $(document).ready(function() {
        $(".accord h3:first").addClass("active");

        $(".accord span:not(:first)").hide();

        $(".accord h3").click(function() {

            $(this).next("span").slideToggle("slow").siblings("span:visible").slideUp("slow");


            $(this).toggleClass("active");

            $(this).siblings("h3").removeClass("active");
        });
    });
    */
</script>
<div id="song" >
    <p id="site" class="blok transition1">
        <a href="https://play.google.com/store/music/album/Бард_который_перевернул_ЗИЛ_зато_очень_недорого?id=Bqxvew7e7qbnwea7eqnjvr53ybu&hl=ru">Вы можете нам помочь купив наши альбомы за символическую цену</a>

    </p>
</div><br>
<div class="accord" style="text-align: left">
<?php /*
<p class="hd">

    <span onmouseup="getContent('<?=$cat_obg->cssclass?>',  <?=$cat_obg->id?>)">еще</span>

</p>
 */ ?>
<?php if(isset($articles)):
    /*$count = count($articles);
    $r = rand(0,$count-1);*/
    foreach($articles as $article) : ?>

    <?php $u =0;/*echo app\components\CustomPagination::widget([
        'pagination' => $artPages,
        'cat' => $cat
    ]);*/
     ?>


        <h3 style="text-align: center"><?=$article['article']->title?></h3>
            <span>

                <div class='content'>

                    <img src="<?=$article['article']->img?>" width="250" height="200" alt="<?=$article['article']->title?>"/>
                    <br />

                    <div id="text_main"><?=$article['article']->text?><hr />
                        <a onclick="showSongs(<?= $article['article']->id ?>)" style="cursor: pointer;">Послушай альбом</a><hr />

                    </div>

                </div>
                <div class="content" id="songs<?= $article['article']->id ?>" style="display: none;">
                    <div id="songs_name">
                    <?php if (isset($article['contents']))  : ?>
                        <?php $i = 0; ?>

                        <?php foreach ($article['contents'] as $cont) :
                            $i++;  ?>
                            <a onclick="nextSong(<?= $cont->id ?>)" style="cursor: pointer;"><?= $i.'-'.$cont->minititle ?></a> ///

                        <?php endforeach; ?>

                    <?php endif; ?>
                    </div>
                </div><br>


            </span>



    <?php endforeach; ?>
    </div>

<?php endif; ?>
