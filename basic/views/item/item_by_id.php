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
        background: #ffffff url(<?=\yii\helpers\Url::to('@web/images/bg.jpg')?>) repeat-y top center;
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

<h3><?=$rec->title?> :: <?=$rec->source->title?> :: <?=$rec->source->author->name ?></h3>
<?php if($rec->audio_link) : ?>
    <audio controls="controls" >
        <source src="http://37.192.187.83:10080/<?=$rec->audio_link?>" type='audio/mpeg'>
    </audio>
<?php endif; ?>
<span class="article"><?=nl2br($rec->text)?></span>