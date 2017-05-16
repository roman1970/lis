<script>
    var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
    $(document).ready(function() {

        $('#book').autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();

                $.getJSON("rockncontroll/default/source-books", function (data) {
                    console.log(data);
                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });


        $("#search").click(
            function() {

                var txt = $("#text").val();

                if (txt == '') {alert('Введите текст!'); return;}

                find(txt, user);

            });

        $("#get_book").click(
            function() {

                var book = $("#book").val();

                if (book == '') {alert('Введите текст!'); return;}

                find_book(book, user);

            });
        
        

        $('#text').focus(
            function () {
                $(this).select();
            });
        
        $('#book').focus(
            function () {
                $(this).select();
            })
        
    });

    function find(txt, user) {

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/article-search",
            data: "text=" + txt + "&user=" + user,
            success: function (html) {
                $("#res").html(html);

            }

        });
    }


    function find_book(book, user) {

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/get-book",
            data: "book=" + book + "&user=" + user,
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
    @media(min-width:320px) and (max-width:767px){.container{width: 100%; padding: 0 3px;}}
    .article {
        display: block;
        color: rgb(105, 102, 105);
        font-size: 17px;
        border-radius: 5px;
        font-family: Ubuntu;
        background: #ffffff url(<?=$this->theme->getUrl('img/bg.jpg')?>) repeat-y top center;
        background-size: 100%;
        line-height: 20px;
        padding: 10px;
        /*color:#333333;
        font-size: 13px;
        line-height: 24px;
         font-family: 'Tinos', sans-serif;*/

    }
    .post__title, h1, h2{
        font-size: 25px;
    }
    img {width: 100%}
    .article {text-align: left}
    .article pre p {color: #0a0a0a; width: 100%}
    .article p {color: color: rgb(105, 102, 105); font-size: 17px; font-family: Ubuntu;}
    h4, h3 {color: #9eb2b1; overflow: hidden;}
    .article ul li {color: rgb(23, 73, 20); font-size: 15px;}
</style>
<div class="container">
    <form class="form-inline center" role="form" id="form-ate">
        <div class="form-group">
            <p>
                <input type="text" class="form-control" id="book" placeholder="Книга">

                <button type="button" class="btn btn-success" id="get_book" >Читать книгу!</button>
            </p>
        </div>
        <div class="form-group">

            <p>
                <input type="text" class="form-control" id="text"  placeholder="Что найти">

                <button type="button" class="btn btn-success" id="search" >Найти статью!</button>
            </p>
            <div id="res">
                <h3>Случайная статья</h3>
                <h4><?=$rec->minititle?> :: <?=$rec->source->title?> :: <?=$rec->source->author->name ?></h4>
                <?php if($rec->audio) : ?>
                    <audio controls="controls" class="audio">
                        <source src='<?=\yii\helpers\Url::to($rec->audio)?>' type='audio/mpeg'>
                    </audio>
                <?php endif; ?>
                <span class="article"><?=$rec->body?></span>
            </div>
        </div>
    </form>

</div>