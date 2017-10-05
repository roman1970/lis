<style>
    .form-group{
        text-align: center;
    }
    .btn-success {
        width: 100%;
    }
    @media(min-width:320px) and (max-width:767px){.container{width: 100%; padding: 0 3px;}}
    .article {
        display: block;
        color: rgb(105, 102, 105);
        font-size: 17px;
        border-radius: 5px;
        font-family: Ubuntu;
        background: #ffffff url(<?=\yii\helpers\Url::to('@web/images/bg.jpg')?>) repeat-y top center;
        background-size: 100%;
        line-height: 20px;
        padding: 10px;
        /*color:#333333;
        font-size: 13px;
        line-height: 24px;
         font-family: 'Tinos', sans-serif;*/

    }
    .article_night{
        display: block;
        color: rgb(218, 212, 195);
        font-size: 17px;
        border-radius: 5px;
        background: none;
        background-size: 100%;
        line-height: 20px;
        padding: 10px;
        text-align: left
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

<h3><?=$rec->minititle?> :: <?=$rec->source->title?> :: <?=$rec->source->author->name ?></h3>
<p style="text-align: center;">
    <button type="button" class="btn btn-success" onclick="daySkinn()" id="day_btn" style="display: none;">День!</button>
    <button type="button" class="btn btn-success" onclick="nightSkinn()" id="night_btn" >Ночь!</button>
</p>

<?php if($rec->audio) : ?>
    <audio controls="controls" class="audio">
        <source src='<?=\yii\helpers\Url::to($rec->audio)?>' type='audio/mpeg'>
    </audio>
<?php endif; ?>
<span class="article"><?=$rec->body?></span>

<script>

    function nightSkinn() {
        //document.getElementsByClassName("article")[0].removeAttribute("class");
        els = document.getElementsByClassName("article");
        for (var j=0; j<els.length; j++)  {
            els[j].setAttribute("class", "article_night");
        }
        day_btn.style.display = 'block';
        night_btn.style.display = 'none';
        codes = document.getElementsByTagName('pre');
        for (var i=0; i<codes.length; i++)  {
            codes[i].style.color = 'white';
            codes[i].style.backgroundColor = 'black';
        }


    }

    function daySkinn() {
        //document.getElementsByClassName("article")[0].removeAttribute("class");

        els = document.getElementsByClassName("article_night");
        for (var j=0; j<els.length; j++)  {
            els[j].setAttribute("class", "article");
        }
        day_btn.style.display = 'none';
        night_btn.style.display = 'block';
        codes = document.getElementsByTagName('pre');
        for (var i=0; i<codes.length; i++)  {
            codes[i].style.color = 'black';
            codes[i].style.backgroundColor = 'white';
        }
    }
</script>