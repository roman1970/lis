
<script>
    $(document).ready(function() {
        $(".accord h4:first").addClass("active");

        $(".accord span").hide();

        $(".accord h4").click(function() {

            $(this).next("span").slideToggle("slow").siblings("span:visible").slideUp("slow");


            $(this).toggleClass("active");

            $(this).siblings("h4").removeClass("active");
        });


    });

    function text_edit(id) {

        window.location = "http://servyz.xyz/plis/articles/updatepage/" + id;
    }

</script>
<style>
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
    .article pre p {color: #0a0a0a; width: 100%}
    .article p {color: color: rgb(105, 102, 105); font-size: 17px; font-family: Ubuntu;}
    h4 {color: #439ab2; overflow: hidden;}
    .article ul li {color: rgb(23, 73, 20); font-size: 15px;}
</style>
<div class="accord" style="text-align: left; color: white; font-size: 20px">
    <?php
    $i=0;

        foreach ($articles as $rec): $i++; ?>
            <hr>
            <h4><?=$i?>) <?=$rec->minititle?> :: <?=$rec->source->title?> :: <?=$rec->source->author->name ?></h4>

            <span class="article">
                  <?php if($rec->audio) : ?>
                      <audio controls="controls" class="audio">
                         <source src='<?=\yii\helpers\Url::to($rec->audio)?>' type='audio/mpeg'>
                      </audio>
                  <?php endif; ?>
                <a href="http://servyz.xyz/plis/articles/show/<?=$rec->id?>">Поделиться ссылкой</a>
                <?=$rec->body?></span>
            <button type="button" class="btn btn-success" onclick="text_edit(<?=$rec->id?>)" id="red_button_<?=$rec->id?>" >Редактировать!</button><br>

            <?php
        endforeach;


        foreach ($items as $rec): $i++; ?>
        <hr>
        <h4><?=$i?>) <?=$rec->title?></h4>
        <span>
            <?php if($rec->audio_link) : ?>
                <audio controls="controls" >
                    <source src="http://37.192.187.83:10080/<?=$rec->audio_link?>" type='audio/mpeg'>
                </audio>
                <br>
                <button type="button" class="btn btn-success" onclick="toPlayList(<?=$rec->id?>)" >Добавить в конец основного плейлиста!</button><br>
            <?php endif; ?>
            <?php if($rec->img) : ?>
                <img src="<?=$rec->img?>">
             <?php endif; ?>

            <?=nl2br($rec->text)?>

            <?='<br>('.$rec->source->title.' - '.$rec->source->author->name.')'?>
        </span>

        <?php
        endforeach;

    ?>
