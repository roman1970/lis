<script>
    var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
    $(document).ready(function() {
        var rand_cases = document.getElementById("#rand_cases");

        $(".accord h4:first").addClass("active");

        $(".accord div").hide();

        $(".accord h4").click(function() {

            $(this).next("div").slideToggle("slow").siblings("div:visible").slideUp("slow");


            $(this).toggleClass("active");

            $(this).siblings("h4").removeClass("active");
        });


        $("#search").click(
            function() {

                var txt = $("#text").val();

                if (txt == '') {alert('Введите текст!'); return;}

                find(txt, user);

            });

        $('#text').focus(
            function () {
                $(this).select();
            });

        $("#bind").click(
            function() {

                var title = $("#idea_title").val();
                alert(title);

                //bind_item(txt, user, idea_id);

            });


    });

    function find(txt, user) {

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/search",
            data: "text=" + txt + "&user=" + user,
            success: function (html) {
                $("#res").html(html);

            }

        });
    }

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



</script>
<style>
    .form-group{
        text-align: center;
    }
</style>
<div class="container">
    <form class="form-inline center" role="form" id="form-ate">
        <div class="form-group">

            <p>
                <input type="text" class="form-control" id="text"  placeholder="Что найти">

                <button type="button" class="btn btn-success" id="search" >Найти!</button>
            </p>
            <div id="res"></div>
        </div>
    </form>

</div>
<div style="text-align: center; color: white" class="accord" id="rand_cases">
    <hr>
    <hr>
    <h3>Набор случаев</h3>
    <hr>
    <?php
    $i=0;
    if(is_array($items_rows)) :
        foreach ($items_rows as $rec): $i++; ?>
            <hr>
            <h4><?=$i?>) <?=$rec->title?></h4>
            <div>
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

                <?=nl2br($rec->text)?>

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
