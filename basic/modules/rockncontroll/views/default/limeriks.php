<style>
    h4{
        color: yellow;
    }
    .txtx{
        color: wheat;
    }
    i{
        cursor: pointer;
    }
    #goTop{
        position: absolute;
        top: -500px;
        left: 7%;
        border-radius: 25px;
        background-color: rgb(181, 70, 35);
        border-color: rgb(200, 71, 36)
    }
</style>
<div class="container">
    <button type="button" class="btn btn-success" id="goTop" >
        <span class="glyphicon glyphicon-arrow-up"></span>
    </button>
    <?php foreach ($limeriks as $limerik) : ?>
        <h4><?=$limerik->title ?></h4>
        <i><?=$limerik->source->title ?>-<?= $limerik->source->author->name ?></i>
        <p class="txtx"><?=nl2br($limerik->text) ?> <i class="glyphicon glyphicon-pencil"  onclick="edit(<?=$limerik->id?>)"></i></p>
    <?php endforeach; ?>
</div>



<script>
    function edit(id) {

        window.location = "http://servyz.xyz/plis/item/update/"+id;

    }
    $(window).scroll(function () {
        if ($(this).scrollTop() > 1000) {
            $('#goTop').stop().animate({
                top: $(this).scrollTop() + $(this).height() - 500
            }, 10000);
        }
        else {
            $('#goTop').stop().animate({
                top: '-500px'
            }, 5000);
        }
    });
    $('#goTop').click(function() {
        $('html, body').stop().animate({
            scrollTop: 0
        }, 1000, function() {
            $('#goTop').stop().animate({
                top: '-500px'
            }, 1000);
        });
    });


</script>
