<style>
    .center, h3{
        text-align: center;
    }
    .table > tbody > tr > td{
        vertical-align: middle;
        font-size: 15px;
        color: rgb(255, 215, 0);
        word-break: break-all;
    }

    h3{
        color: rgb(255, 215, 0);
    }
    .glyphicon {
        color: gold !important;
    }
</style>

<?php  if(is_array($songs)) :
   foreach ($songs as $song):  ?>

<p><?=$song->title?> - <?=$song->source->title?></p>
<p><?=$song->link?></p>



<audio controls="controls" ">
   <source src="http://localhost:8088<?=$song->link?>" type='audio/mpeg'>
</audio>

   <?php endforeach; ?>
<?php endif; ?>


