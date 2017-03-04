<script>
    var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
    $(document).ready(function() {
        $(".accord h4:first").addClass("active");

        $(".accord div").hide();

        $(".accord h4").click(function() {

            $(this).next("div").slideToggle("slow").siblings("div:visible").slideUp("slow");


            $(this).toggleClass("active");

            $(this).siblings("h4").removeClass("active");
        });


    });

    function publish(id) {

        var title = $("#new_title_" + id).val();
        var text = $("#new_text_" + id).val();
        //alert(title);

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/copyright",
            data: "title=" + title + "&text=" + text + "&user=" + user + "&id=" + id,
            success: function (html) {
                $("#res").html(html);

            }

        });
    }
</script>
<style>
    h4,p{
        color: white;
    }
    .text{
        font-size: 15px;
        color: rgb(255, 255, 255);
    }
    .center{
        text-align: center;
    }
</style>

<div id="res" class="accord">
    <?php foreach($content as $item):?>
        <h4><?= $item->link ?></h4>
        <div class="text"><p style="height: 150px; overflow: auto"><?= $item->description ?></p>
        <form class="form-inline center" role="form" id="form-event">
            <input type="text" class="form-control" id="new_title_<?=$item->id?>"  placeholder="Титул">
            <textarea class="form-control" id="new_text_<?=$item->id?>"  placeholder="Текст новости" rows="10" cols="45"></textarea>
            <br>
            <button type="button" class="btn btn-success" onclick="publish(<?=$item->id?>)" >Опубликовать новость!</button>
           
        </form>
        </div>
    <?php endforeach; ?>

</div>

