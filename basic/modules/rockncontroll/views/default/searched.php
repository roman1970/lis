<style>
    img{width: 100%}
</style>
<div style="text-align: center; color: white">
    <h3>Краткости талантов</h3>
    <?php
        $i=0;
        if(is_array($items_rows)) :
            foreach ($items_rows as $rec): $i++;
                ?>
                <hr>
                <h4><?=$i?>) <?=$rec->title?></h4>
                <p><?=nl2br($rec->text)?></p>
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
