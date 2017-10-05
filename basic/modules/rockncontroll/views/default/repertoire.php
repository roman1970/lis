<script>
    var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
    $(document).ready(function() {
        $(".accord h3:first").addClass("active");

        $(".accord span").hide();

        $(".accord h3").click(function() {

            $(this).next("span").slideToggle("slow").siblings("span:visible").slideUp("slow");

            $(this).toggleClass("active");

            $(this).siblings("h3").removeClass("active");

        });

    });

    function scrollText(id) {
        var el = document.getElementById('sn_'+id);
        el.scrollIntoView();
    }

    function autocompl(id) {

        $('#id_' + id).autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();
                console.log(term);
                $.getJSON("rockncontroll/default/songs", function (data) {

                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });

    }

    function autocomplConc(id) {

        $('#concert_' + id).autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();
                console.log(term);
                $.getJSON("rockncontroll/default/concerts", function (data) {

                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });

    }

    function saveNextSong(user, id) {

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/save-next-song/",
            data: "user="+user+"&id="+id,
            success: function(html){
                $("#res").html(html);
            }

        });

    }
    
    function frash(user) {
        $.ajax({
            type: "GET",
            url: "rockncontroll/default/frash/",
            data: "user="+user,
            success: function(html){
                $("#res_qu").html(html);
            }

        });
        
    }
    
    function add_original(id) {
        var title = $("#id_" + id).val();
        //alert(title);
        $.ajax({
            type: "GET",
            url: "rockncontroll/default/add-original/",
            data: "user="+user+"&id="+id+"&title="+title,
            success: function(html){
                $("#res_orig_" + id).html(html);
            }

        });
    }
    
    function bind_concert(id) {
        var concert = $("#concert_" + id).val();
        //alert(title);
        $.ajax({
            type: "GET",
            url: "rockncontroll/default/bind-concert/",
            data: "user="+user+"&id="+id+"&concert="+concert,
            success: function(html){
                $("#res_conc_" + id).html(html);
            }

        });
        
    }

    function edit(id) {

        window.location = "http://servyz.xyz/plis/item/update/"+id;

        //var txt = document.getElementById("text_edited_" + id).innerHTML;

        //alert(txt); exit;

        /*$.ajax({
            type: "GET",
            url: "rockncontroll/default/edit-item-text",
            data:{edited:txt,user:user,id:id},//параметры запроса
            //data: "edited=" + txt + "&user=" + user + "&id=" + id,
            success: function (html) {
                $("#res").html(html);

            }

        });
        */
    }
</script>
<style>
    .accord{
        text-align: center;
    }
    .song-name{
        font-size: 18px;
        color: rgb(255, 250, 240);
        cursor: pointer;

    }
    .song-text{
        font-size: 16px;
        color: rgb(255, 253, 150);
        width: 100%;

    }
    .block{
        border: 4px groove rgb(255, 215, 0);
        /*background: rgba(19, 19, 38, 0.94);  */
        margin-bottom: 10px;
        border-radius: 5px;
        width: 100%;
        color: rgb(225, 238, 96);
        font-size: 13px;
        line-height: normal;
    }
    h4{
        color: yellow;
    }
    .short{
        width: 100%;
        height: 38px;
        overflow: hidden;
        padding: 5px 10px;
        font-size: 10px;
        color: rgb(245, 222, 179);
        text-align: center;
    }
    .thougth{
        color: rgb(139, 154, 245);
        font-size: 10px;
    }
    .yell{

        color: rgb(245, 200, 107);

    }
</style>

<div id="res"></div>
<div class="accord">

    <?php // var_dump($thoughts);
    //echo $thoughts[rand(0,count($thoughts-1))]->text;  ?>

    <h4>Повторяем</h4>
    <hr>

    <?php foreach ($repeats as $repeat):  ?>

        <h3 class="song-name" id="sn_<?=$repeat->item->id?>" onclick="scrollText(<?=$repeat->item->id?>)">  <?= $repeat->item->title ?> <br><p class="short"><?=nl2br($repeat->item->text)?></p></h3>


        <span class="song-text" >
              <?php if($repeat->item->original_song_id) : ?>

                  <audio controls="controls" >
                     <source src="http://37.192.187.83:10080/<?=$repeat->item->original->link?>" >
                  </audio>
                  <br>

              <?php else : ?>

                  <form class="form-inline center" role="form" id="form-add-original">
                        <input type="text" class="form-control" id="id_<?=$repeat->item->id?>" onfocus="autocompl(<?=$repeat->item->id?>)" placeholder="Оригигнал">
                        <br>
                        <button type="button" class="btn btn-success" onclick="add_original(<?=$repeat->item->id?>)" >Добавить оригинал!</button>
                  </form>
                  <br>
                  <p id="res_orig_<?=$repeat->item->id?>"></p>

              <?php endif; ?>
            <?php if($repeat->item->audio_link) : ?>

                <audio controls="controls" >
                     <source src="http://37.192.187.83:10080/<?=$repeat->item->audio_link?>" >
                  </audio>
                <br>

            <?php endif; ?>

            <div class="block" id="text_edited_<?=$repeat->item->id?>" ><?=nl2br($repeat->item->text)?></div>
            <button type="button" class="btn btn-success" onclick="edit(<?=$repeat->item->id?>)" >Редактировать!</button><br>



        </span>
        <hr>
    <?php endforeach; ?>
    <hr>



    <h4>Текущее</h4>
    <hr>

    <?php foreach ($songs as $song): ?>

        <h3 class="song-name" id="sn_<?=$song->id?>" onclick="scrollText(<?=$song->id?>)">
            <input type="radio" name="reper" onclick="saveNextSong(user, <?= $song->id ?>)" value="<?= $song->id ?>" > <?= $song->title ?>
            <br>
            <p class="short">
                <?=nl2br($song->text)?>
            </p>
            
                <?php if($repers = \app\models\RepertuareItem::find()->where(['item_reper_id' => $song->id])->all()) : ?>
                 <p class="thougth">

                    <?php foreach ($repers as $thought): ?>
                        <?=\app\models\Items::findOne($thought->item_phrase_id)->text ?>
                    <?php endforeach; ?>
                 </p>
                <?php endif; ?>

           </h3>


        <span class="song-text" >
              <?php if($song->original_song_id) : ?>

                  <audio controls="controls" >
                     <source src="http://37.192.187.83:10080/<?=$song->original->link?>" >
                  </audio>
                  <br>

              <?php else : ?>

                  <form class="form-inline center" role="form" id="form-add-original">
                        <input type="text" class="form-control" id="id_<?=$song->id?>" onfocus="autocompl(<?=$song->id?>)" placeholder="Оригигнал">
                        <br>
                        <button type="button" class="btn btn-success" onclick="add_original(<?=$song->id?>)" >Добавить оригинал!</button>
                  </form>
                  <br>
                  <p id="res_orig_<?=$song->id?>"></p>

              <?php endif; ?>

            <?php if($song->audio_link) : ?>

                <audio controls="controls" >
                     <source src="http://37.192.187.83:10080/<?=$song->audio_link?>" >
                  </audio>
                <br>

            <?php endif; ?>


            <div class="block" id="text_edited_<?=$song->id?>" ><?=nl2br($song->text)?></div>
            <button type="button" class="btn btn-success" onclick="edit(<?=$song->id?>)" >Редактировать!</button><br>

            <?php $concs = \app\models\PlistBind::find()->where("item_id=$song->id")->all();
                foreach ($concs as $pl): ?>
                   <?= \app\models\Playlist::findOne($pl->play_list_id)->name ?>
            <?php endforeach; ?>
            <form class="form-inline center" role="form" id="form-bind-concert">
                        <input type="text" class="form-control" id="concert_<?=$song->id?>" onfocus="autocomplConc(<?=$song->id?>)" placeholder="Концертный статус">
                        <br>
                        <button type="button" class="btn btn-success" onclick="bind_concert(<?=$song->id?>)" >Привязать концертный статус!</button>
            </form>
            <p id="res_conc_<?=$song->id?>"></p>



        </span>
        <hr>
    <?php endforeach; ?>


</div>
<div id="res_qu">
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="frash(user)">Сброс очереди</button>
</div>

