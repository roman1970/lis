<script>
    var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
    $(document).ready(function() {

        $('#cat').autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();
                console.log(term);
                $.getJSON("rockncontroll/default/deal-cats", function (data) {

                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });

        $('#source').autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();
                console.log(term);
                $.getJSON("rockncontroll/default/sources", function (data) {

                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });

        $("#record").click(
            function() {

                var title = $("#title").val();
                var source = $("#source").val();
                var cat = $("#cat").val();
                var tags = $("#tags").val();
                var txt = $("#text").val();
                var old_data = $("#old_data").val();
                var cens = $("#cens").val();
                var published = $("#published").val();
                

                if (title == '') {alert('Введите название!'); return;}
                if (source == '') {alert('Введите источник!'); return;}
                if (cat == '') {alert('Введите категорию!'); return;}
                if (tags == '') {alert('Введите тэги!'); return;}
                if (cens == '') {alert('Введите уровень цензуры!'); return;}
                if (txt == '') {alert('Введите текст!'); return;}
                if (old_data == '') {old_data = 0;}
                if (published == '') {published = 1;}

                rec(title, source, cat, tags, txt, user, old_data, cens, published);

            });

        $('#dish').focus(
            function () {
                $(this).select();
            })
        $('#measure').focus(
            function () {
                $(this).select();
            })

    });

    $('.fileinput').change(function(){
        var fd = new FormData();

        console.log(this.files);

        fd.append("userpic", this.files[0]);

        console.log(this.files);

        $.ajax({
            url: "rockncontroll/default/upload",
            type: "POST",
            data: fd,
            dataType: 'json',
            //maxFileSize: 256 * 1014,
            allowedTypes: 'image/*',
            cache: false,
            contentType: false,
            processData: false,
            forceSync: false,
            success: function(html){
                $("#res").html(html);

            }
        });
    });


    function rec(title, source, cat, tags, txt, user, old_data, cens, published) {

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/record-item",
            data: "title="+title+"&source="+source+"&cat="+cat+"&tags="+tags+"&txt="+txt+"&user="+user+"&old_data="+old_data+"&cens="+cens+"&published="+published,
            success: function(html){
                $("#res").html(html);

            }

        });

    }
    


</script>

<style>
    .center, h3, table > tbody > tr > td{
        text-align: center;
    }
    .table > tbody > tr > td{
        vertical-align: middle;
        font-size: 15px;
        color: rgb(255, 215, 0);
    }
    h3{
        color: rgb(255, 215, 0);
    }
    

    .form-control {
        width: 100%;
    }


</style>

<div class="container">
    <form class="form-inline center" role="form" id="form-ate">
        <div class="form-group">
            <h3>Есть что?</h3>
            <p>
                <input type="text" class="form-control" id="title"  placeholder="Титул">
                <input type="text" class="form-control" id="source"  placeholder="Источник">
                <input type="text" class="form-control" id="cat"  placeholder="Категория">
                <input type="text" class="form-control" id="tags"  placeholder="Тэги">
                <input type="text" class="form-control" id="published"  placeholder="Опубликовать 1, нет 0">
                <input type="text" class="form-control" id="cens"  placeholder="Уровень цензуры, 0 - +6" value="0">
                <input type="text" class="form-control" id="old_data"  placeholder="Дата в формате ГГГГ-ММ-ДД">
                <textarea class="form-control" id="text"  placeholder="Текст" rows="10" cols="45"></textarea>
                <br>
                <button type="button" class="btn btn-success" id="record" >Записать!</button>
            </p>
            <div id="res"></div>
        </div>
    </form>
   <?php // <input class="fileinput" name="userpic" type="file" /> ?>
</div>