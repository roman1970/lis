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

</script>

<?php foreach ($content as $cnt) : ?>

    <div class='content'>
        <img src="<?=$this->theme->getUrl($cnt->img)?>" width="250" height="200" alt="Доктор Грэйв - зато очень не дорого"/>
        <br />

        <div id="text_main"><?=$cnt->text?><hr />
            <a onclick="nextSong()" style="cursor: pointer;">Ткни на цифру и послушай</a><hr />
            <?php $i = 0;

            foreach ($articles as $article) :
                $i++; ?>
                <a onclick="nextSong(<?= $article->id ?>)" style="cursor: pointer;"><?= $i.'-'.$article->minititle ?></a><br>

            <?php endforeach; ?>
        </div>

    </div>


    <div class="content" id="song" style="display: none;">

    </div><br>
<?php endforeach; ?>
