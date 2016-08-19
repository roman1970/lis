<script>
    var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
    $(document).ready(function() {

        $('#cat').autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();
                console.log(term);
                $.getJSON("rockncontroll/default/cats", function (data) {

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

                if (title == '') {alert('Введите название!'); return;}
                if (source == '') {alert('Введите источник!'); return;}
                if (cat == '') {alert('Введите категорию!'); return;}
                if (tags == '') {alert('Введите тэги!'); return;}
                if (txt == '') {alert('Введите текст!'); return;}

                rec(title, source, cat, tags, txt, user);

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


    function rec(title, source, cat, tags, txt, user) {

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/record-item",
            data: "title="+title+"&source="+source+"&cat="+cat+"&tags="+tags+"&txt="+txt+"&user="+user,
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
                <textarea class="form-control" id="text"  placeholder="Текст" rows="10" cols="45"></textarea>
                <br>
                <button type="button" class="btn btn-success" id="record" >Записать!</button>
            </p>
            <div id="res"></div>
        </div>
    </form>
</div>