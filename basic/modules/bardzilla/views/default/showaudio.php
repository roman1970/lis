<script>

    function setLike(idLike) {
        count = 0;
        $.post("bardzilla/default/setLike", {id: idLike}, function(data) {
            count = data;

        });

        $("#count_" + idLike).ajaxSuccess(function() { //убираем количество после голосования
            $(this).text(count);
            $(this).hide();

        });

        $("#nr_" + idLike).ajaxSuccess(function() {   //убираем "Нравится" после голосования

            $(this).hide();

        });
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

       // $("#nr_" + idLike).ajaxSuccess(function() {   //убираем "Нравится" после голосования

       //     $(this).hide();

       // });
    }

    function showSongs(){
        $("#songs").show();
    }

</script>

<?php foreach ($content as $cnt) : ?>

    <div class='content'>
        <img src="<?=$cnt->img?>" width="250" height="200" alt="<?=$cnt->title?>"/>
        <br />

        <div id="text_main"><?=$cnt->text?><hr />
            <a onclick="showSongs()" style="cursor: pointer;">Послушай альбом</a><hr />

        </div>

    </div>
    <div class="content" id="songs" style="display: none;">
        <div id="songs_name">
        <?php $i = 0;

        foreach ($articles as $article) :
            $i++; ?>
            <a onclick="nextSong(<?= $article->id ?>)" style="cursor: pointer;"><?= $i.'-'.$article->minititle ?></a> ///

        <?php endforeach; ?>
            </div>
    </div><br>

    <div id="song" style="display: none;">

    </div><br>
<?php endforeach; ?>
