<script>
    $(document).ready(function() {
        $(".accord h4:first").addClass("active");

        $(".accord p").hide();

        $(".accord h4").click(function() {

            $(this).next("p").slideToggle("slow").siblings("p:visible").slideUp("slow");


            $(this).toggleClass("active");

            $(this).siblings("h4").removeClass("active");
        });


    });
</script>

<style>
    img{width: 100%}
    h4{cursor: pointer}

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
    <h3>Краткости талантов</h3>
    <?php
        $i=0;
        if(is_array($items_rows)) :
            foreach ($items_rows as $rec): $i++;
                ?>
                <hr>
                <h4><?=$i?>) <?=$rec->title?></h4>
                <p>
                    <?php if($rec->audio_link) : ?>
                        <audio controls="controls" >
                            <source src="http://37.192.187.83:10080/<?=$rec->audio_link?>" type='audio/mpeg'>
                        </audio><br>
                    <?php endif; ?>
                    <?php if($rec->img) : ?>
                        <img src="<?=$rec->img?>">
                    <?php endif; ?>
                    <?=nl2br($rec->text)?>
                    <?='('.$rec->source->title.' - '.$rec->source->author->name.')'?>
                </p>
                <?php
            endforeach;
            else: echo $items_rows;
        endif;
    ?>
    <h3>События</h3>
    <?php
        if(is_array($events_rows)) :
            foreach ($events_rows as $rec): $i++;
                ?>
                <hr>
                <h4><?=$i?>) <?=date('Y-m-d', $rec->act->time)?></h4>
                <p><?=nl2br($rec->text)?></p>
                <?php if($rec->img) : ?>
                <p><img src="<?=$rec->img?>"></p>
                <?php endif; ?>
                <?php
            endforeach;
        else: echo $events_rows;
    endif;
    ?>
</div>
