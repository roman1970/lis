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

    <div class='content'>
        <img src="<?=$this->theme->getUrl('Img/DoctorGraveZatoOchen_big.jpg')?>" width="250" height="200" alt="Доктор Грэйв - зато очень не дорого"/>
        <br />

        <div id="text_main">"...зато очень недорого!" - альбом, записанный Б,КПЗ в 2011 году с ансамблем, все участники которого - инопланетяне. Это они дали этому эклектичному проекту такое
            глубокое, но мало кому доступное для анализа его сути название - Доктор Грэйв.<hr />
            <a onclick="nextSong()" style="cursor: pointer;">Ткни на цифру и послушай</a><hr />
            <?php $i = 0;
            foreach ($articles as $article) :
                $i++; ?>
                <a onclick="nextSong(<?= $article->id ?>)" style="cursor: pointer;"><?= $i ?></a>|

            <?php endforeach; ?>
        </div>

    </div>


    <div class="content" id="song" style="display: none;">

    </div><br>
