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
    img{width: 100%}
    span,pre{color: #0a0a0a; width: 100%}
    h4{color: white; overflow: hidden;}
</style>
<div class="accord" style="text-align: left; color: white; font-size: 20px">
    <?php
    $i=0;
    if(is_array($articles_rows)) :
        foreach ($articles_rows as $rec): $i++;
            ?>
            <hr>
            <h4><?=$i?>) <?=$rec->minititle?></h4>
            <span><?=nl2br($rec->body)?></span>
            <?php
        endforeach;
    else: echo $articles_rows;
    endif;
    ?>
</div>
