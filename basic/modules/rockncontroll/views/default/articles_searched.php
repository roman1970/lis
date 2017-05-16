
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
    if(is_array($articles_rows)) :
        foreach ($articles_rows as $rec): $i++;
            ?>
            <hr>
            <h4><?=$i?>) <?=$rec->minititle?> :: <?=$rec->source->title?> :: <?=$rec->source->author->name ?></h4>

            <span class="article">
                  <?php if($rec->audio) : ?>
                      <audio controls="controls" class="audio">
                         <source src='<?=\yii\helpers\Url::to($rec->audio)?>' type='audio/mpeg'>
                      </audio>
                  <?php endif; ?>
                <?=$rec->body?></span>
            <?php
        endforeach;
    else: echo $articles_rows;
    endif;
    ?>
</div>
