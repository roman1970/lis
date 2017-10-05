<script>
    var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
    $(document).ready(function() {
        
        //alert(rand_cases);
        if(typeof rand_cases != "undefined") rand_cases.remove();

        $(".accord h4:first").addClass("active");

        $(".accord div").hide();

        $(".accord h4").click(function() {

            $(this).next("div").slideToggle("slow").siblings("div:visible").slideUp("slow");


            $(this).toggleClass("active");

            $(this).siblings("h4").removeClass("active");
        });

        $("#bind").click(
            function() {

                var title = $("#idea_title").val();
                alert(title);

                //bind_item(txt, user, idea_id);

            });



    });

    function bind(id) {

        var title = $("#idea_title_" + id).val();
        //alert(title);

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/bind-project-item",
            data: "idea=" + title + "&user=" + user + "&id=" + id,
            success: function (html) {
                $("#res").html(html);

            }

        });
    }

    function bindItem(id) {

        var title = $("#item_title_" + id).val();
        //alert(title);

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/bind-next-item",
            data: "next=" + title + "&user=" + user + "&id=" + id,
            success: function (html) {
                $("#res").html(html);

            }

        });
    }
    
    function bindReperItem(id) {
        var title = $("#item_reper_" + id).val();
        //alert(title);

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/bind-reper-item",
            data: "reper=" + title + "&user=" + user + "&id=" + id,
            success: function (html) {
                $("#res").html(html);

            }

        });
    }
    
    function addInWork(id) {
        var text = $("#in_work_item_" + id).val();
        //alert(title);

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/add-in-work",
            data: "text=" + text + "&user=" + user + "&id=" + id,
            success: function (html) {
                $("#res").html(html);

            }

        });
    }
    
    function addItemToRadioContent(id) {
        var cat = $("#category_post_" + id).val();
        var anons = $("#anons_post_" + id).val();
        var title = $("#title_post_" + id).val();

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/cat-post",
            data: "cat=" + cat +  "&anons=" + anons + "&title=" + title + "&user=" + user + "&id=" + id,
            success: function (html) {
                $("#res").html(html);

            }

        });
        
    }
    
    function toPlayList(id) {
        $.ajax({
            type: "GET",
            url: "rockncontroll/default/add-item-to-play-list",
            data: "user=" + user + "&id=" + id,
            success: function (html) {
                $("#res").html(html);

            }

        });
    }

    function autocompl(id) {

        $('#idea_title_' + id).autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();
                console.log(term);
                $.getJSON("rockncontroll/default/ideas", function (data) {

                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });

    }

    function autocompl_item(id) {

        $('#item_title_' + id).autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();
                console.log(term);
                $.getJSON("rockncontroll/default/items", function (data) {

                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });

    }
    
    function autocompl_reper(id){

        $('#item_reper_' + id).autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();
                console.log(term);
                $.getJSON("rockncontroll/default/rep-items", function (data) {

                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });
        
    }

    function autocompl_cat_radio(id) {

        $('#category_post_'+ id).autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();
                console.log(term);
                $.getJSON("rockncontroll/default/cat-post-radio", function (data) {

                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });

    }

    function autocompl_theme_radio(id) {

        $('#theme_title_'+ id).autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();
                console.log(term);
                $.getJSON("rockncontroll/default/theme-radio", function (data) {

                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });

    }
    
    function createTheme(id) {
        var title = $("#theme_title_" + id).val();

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/create-theme",
            data: "user=" + user + "&title=" + title,
            success: function (html) {
                $("#res").html(html);

            }

        });
    }

    function bindItemToTheme(id) {
        var title = $("#theme_title_" + id).val();

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/bind-item-to-theme",
            data: "user=" + user + "&title=" + title + "&id=" + id,
            success: function (html) {
                $("#res").html(html);

            }

        });

    }

    function text_edit(id) {

        window.location = "http://servyz.xyz/plis/item/update/"+id;

        /*

        var txt = document.getElementById("text_edited_" + id).innerHTML;

        //alert(txt); exit;

        $.ajax({
            type: "POST",
            method: "POST",
            //url: "rockncontroll/itemapi/update/2830",
            dataType: 'json',
            //data: {text: text},
            url: "http://plis/item/edit-item-text",
            //data:{edited:txt,user:user,id:id},//параметры запроса
            data: '{"edited"}',
           // contentType: "application/json; charset=utf-8",
            //dataType: "json",
           // data: "edited=txt&user=user&id:id",
            //data: "edited=txt&user=user&id=id",
            //data:{'cens':2},
            //data: {'edited':txt,'user':user,'id':id, 'url':'edit-item-text'},
            //data: $("#register_ajax").serialize(),
            //data: "edited=" + txt + "&user=" + user + "&id=" + id,
            success: function (html) {
                $("#res_" + id).html(html);
                $("#red_button_" + id).hide();

            }

        });
        */
    }

</script>

<style>
    img{width: 100%}
    h4{cursor: pointer}
    h3{ color: rgb(255, 215, 0); }

    audio
    {
        -webkit-transition:all 0.5s linear;
        -moz-transition:all 0.5s linear;
        -o-transition:all 0.5s linear;
        transition:all 0.5s linear;
        -moz-box-shadow: 2px 2px 4px 0px #006773;
        -webkit-box-shadow:  2px 2px 4px 0px #006773;
        box-shadow: 2px 2px 4px 0px #006773;
        -moz-border-radius:7px 7px 7px 7px ;
        -webkit-border-radius:7px 7px 7px 7px ;
        border-radius:7px 7px 7px 7px ;
    }

    audio:hover, audio:focus, audio:active
    {
        -webkit-box-shadow: 15px 15px 20px rgba(0,0, 0, 0.4);
        -moz-box-shadow: 15px 15px 20px rgba(0,0, 0, 0.4);
        box-shadow: 15px 15px 20px rgba(0,0, 0, 0.4);
        -webkit-transform: scale(1.05);
        -moz-transform: scale(1.05);
        transform: scale(1.05);
    }
</style>

<div style="text-align: center; color: white" class="accord">
    <hr>
    <hr>
    <h3>Краткости талантов</h3>
    <hr>
    <?php
        $i=0;
        if(is_array($items_rows)) :
            foreach ($items_rows as $rec): $i++; ?>
                <hr>
                <h4><?=$i?>) <?=$rec->title?></h4>
                <div>
                    <a href="http://servyz.xyz/plis/item/show/<?=$rec->id?>">Поделиться ссылкой</a><br>
                    <?php if($rec->audio_link) : ?>
                        <audio controls="controls" >
                            <source src="http://37.192.187.83:10080/<?=$rec->audio_link?>" type='audio/mpeg'>
                        </audio><br>
                        <button type="button" class="btn btn-success" onclick="toPlayList(<?=$rec->id?>)" >Добавить в конец основного плейлиста!</button><br>
                    <?php endif; ?>
                    <?php if($rec->img) : ?>
                        <img src="<?=$rec->img?>">
                    <?php endif;
                    ?>
                    
                    <p contenteditable="true" id="text_edited_<?=$rec->id?>"><?=nl2br($rec->text)?></p>
                    <button type="button" class="btn btn-success" onclick="text_edit(<?=$rec->id?>)" id="red_button_<?=$rec->id?>" >Редактировать!</button><br>
                    <a href="http://servyz.xyz/plis/item/update/<?=$rec->id?>">Редактировать</a><br>
                    <p id="res_<?=$rec->id?>"></p>

                    <?='<br>('.$rec->source->title.' - '.$rec->source->author->name.')'?>
                    <form class="form-inline center" role="form" id="form-idea">
                        <input type="text" class="form-control" id="idea_title_<?=$rec->id?>" onfocus="autocompl(<?=$rec->id?>)" placeholder="Идея">
                        <br>
                        <button type="button" class="btn btn-success" onclick="bind(<?=$rec->id?>)" >Привязать айтем к идее!</button>
                    </form>
                    <form class="form-inline center" role="form" id="form-next">
                        <input type="text" class="form-control" id="item_title_<?=$rec->id?>" onfocus="autocompl_item(<?=$rec->id?>)" placeholder="Next item <?=$rec->parent_item_id?>">
                        <br>
                        <button type="button" class="btn btn-success" onclick="bindItem(<?=$rec->id?>)" >Привязать как следующий!</button>
                    </form>
                    <form class="form-inline center" role="form" id="form-bind-reper">
                        <input type="text" class="form-control" id="item_reper_<?=$rec->id?>" onfocus="autocompl_reper(<?=$rec->id?>)" placeholder="Вещь репертуара">
                        <br>
                        <button type="button" class="btn btn-success" onclick="bindReperItem(<?=$rec->id?>)" >Привязать к песне репертуара!</button>
                    </form>
                    <form class="form-inline center" role="form" id="form-work">
                        <input type="text" class="form-control" id="in_work_item_<?=$rec->id?>" onfocus="autocompl_item(<?=$rec->id?>)" placeholder="Примечане в работе">
                        <br>
                        <button type="button" class="btn btn-success" onclick="addInWork(<?=$rec->id?>)" >Добавить в работу!</button>
                    </form>
                    <form class="form-inline center" role="form" id="form-cat-post">
                        <input type="text" class="form-control" id="category_post_<?=$rec->id?>" onfocus="autocompl_cat_radio(<?=$rec->id?>)" placeholder="Категория">
                        <input type="text" class="form-control" id="anons_post_<?=$rec->id?>" placeholder="Анонс">
                        <input type="text" class="form-control" id="title_post_<?=$rec->id?>" value="<?=$rec->title?>">
                        <br>
                        <button type="button" class="btn btn-success" onclick="addItemToRadioContent(<?=$rec->id?>)" >Добавить айтем в контент радио!</button>
                    </form>
                    <form class="form-inline center" role="form" id="form-create-theme">
                        <input type="text" class="form-control" id="theme_title_<?=$rec->id?>" onfocus="autocompl_theme_radio(<?=$rec->id?>)" placeholder="Новая тема">
                        <br>
                        <button type="button" class="btn btn-success" onclick="createTheme(<?=$rec->id?>)" >Создать тему для радио!</button>
                        <button type="button" class="btn btn-success" onclick="bindItemToTheme(<?=$rec->id?>)" >Привязать к теме айтем!</button>
                    </form>
                </div>

            <?php
               endforeach;
            else: echo $items_rows;
        endif;
    ?>
    <hr>
    <hr>
    <h3>События</h3>
    <hr>
    <?php //var_dump($events_rows); exit;
        if(is_array($events_rows)) :
            foreach ($events_rows as $rec): $i++;
                ?>
                <hr>
                <h4><?=$i?>) <?=date('Y-m-d', $rec->act->time)?></h4>
                <div><?=nl2br($rec->text)?><br>
                <?php if($rec->img) : ?>
                <img src="<?=$rec->img?>">
                <?php endif; ?>
                </div>
                <?php
            endforeach;
        else: echo $events_rows;
    endif;
    ?>
    <hr>
    <hr>
    <h3>Новости</h3>
    <hr>
    <?php //var_dump($events_rows); exit;
    if(is_array($news_rows)) :
        foreach ($news_rows as $rec): $i++;
            ?>
            <hr>
            <h4><?=$i?>) <?=$rec->title?></h4>
            <div><?=nl2br($rec->description)?></div>
        <?php endforeach;
    else: echo $news_rows;
    endif;
    ?>
</div>
