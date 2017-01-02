
<style>
    h4,p, #silent{
        color: white;
    }
</style>

<div id="silent">Включить радио</div>

<audio controls="controls" >
    <source src="http://37.192.187.83:10088/ices" >
</audio>

<?php foreach ($songs as $author => $song): ?>

    <h4><?=$author?></h4><p><?=$song?></p>

<?php endforeach; ?>
