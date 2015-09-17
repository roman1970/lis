<script>
$(document).ready(function() {
$(".accord h3:first").addClass("active");

$(".accord p:not(:first)").hide();

$(".accord h3").click(function() {

$(this).next("p").slideToggle("slow")
.siblings("p:visible").slideUp("slow");

$(this).toggleClass("active");

$(this).siblings("h3").removeClass("active");


});
});
</script>




<div class="accord">

    <h1></h1>
    <p></p>
    <?php foreach ($articles as $article) : ?>

    <h3> <?= $article->minititle ?></h3>
    <?= $article->body ?>

    <?php endforeach; ?>



    <h3>Коммуналка</h3>
    <p>Лицо моего соседа Ивана <br/>
        Выглядело вполне серьёзно: <br/>
        "Диетический лондарик буш?" <br/>
        Но подошла очередь в душ...<br/>
        "Вчера было ещё рано, а завтра будет уже поздно!" <br/>
        - истерически за стенкой кричал ленин муж...
    </p>

    <h3>Твоя борьба</h3>
    <p>Каждый - есть личность, каждый - есть что-то <br/>
        И соответствуя с вложенной природой задачей, <br/>
        Мы бьёмся... Или не бьёмся и плачем... <br/>
        Чтобы быть если не лучше, то хоть выше кого-то...
    </p>

    <h3>Штрафные санкции</h3>
    <p> - Ой, ну чо ты, командир, от меня чего ты хочешь? <br/>
        Чо ты злой как крокодил и когда кричать ты кончишь <br/>
        Ну и чо, что опоздал, ты ведь сам припёрся к часу <br/>
        Ну и чо, что болт украл, а ты купил уж третью Мазду
    </p>

    <h3>Православный патриот</h3>
    <p> - Ну что ты бормочешь, чурка, бля-нах <br/>
        Отведать не хош крови вкуса <br/>
        Да как меня покарает аллах, <br/>
        Если я верю в Иисуса!</p>

    <h3>Прощайте!</h3>
    <p>Где же вы умные люди <br/>
        Где же вы разума дети <br/>
        В прошлое на развесёлой комете  <br/>
        Мы улетаем, и вами не будем... <br/>
    </p>

    <h3>Весёлый детский праздник </h3>
    <p>Бармалей кричит: "Налей!" <br/>
        Карабас орёт: "Не квас!" <br/>
        Загуляли папы, мамы,<br />
        А День Рождения у нас!
    </p>

    <h3>Смелость рушит города и отношения </h3>
    <p>Безопасный - значит бесполезный! <br/>
        Ваша осторожность мне сердце дерёт <br/>
        И пусть под ногами вновь пропасть бездны: <br/>
        Кто не рискует - не пьёт, не курит и с женою живёт!
    </p>

</div>

<p id="more" data-num="1" >Ещё</p>
