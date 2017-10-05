<script>
    $(document).ready(function() {
        $(".accord h3:first").addClass("active");

        $(".accord span").hide();

        $(".accord h3").click(function() {

            $(this).next("span").slideToggle("slow").siblings("span:visible").slideUp("slow");


            $(this).toggleClass("active");

            $(this).siblings("h3").removeClass("active");
        });


    });

    function autocompl() {

        $('#concert').autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();
                console.log(term);
                $.getJSON("rockncontroll/default/concerts", function (data) {

                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });

    }

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
    
    function generateConcert() {
        var concert = $("#concert").val();
        //alert(title);
        $.ajax({
            type: "GET",
            url: "rockncontroll/default/generate-concert/",
            data: "user="+user+"&concert="+concert,
            success: function(html){
                $("#res").html(html);
            }

        });
        
    }
</script>
<style>
    .accord{
        text-align: center;
    }
    .song-name{
        font-size: 18px;
        color: rgb(255, 250, 240);
        cursor: pointer;

    }
    .song-text{
        font-size: 16px;
        color: rgb(255, 253, 150);

    }
    .phrase{
        color: #acd57e;
    }
</style>


<form class="form-inline center" role="form" id="form-add-original">
    <input type="text" class="form-control" id="concert" onfocus="autocompl()" placeholder="Концерт">
    <br>
    <button type="button" class="btn btn-success" onclick="generateConcert()" >Генерировать концерт!</button>
</form>
<div class="accord" id="res">


    <?php /*foreach ($songs as $song): var_dump($song); exit;?>

        <h3 class="song-name"> <?= $song->title ?> </h3>


         <span class="song-text">
             <br>
             <hr>
             <p class="phrase"><?= nl2br($song->phrase2) ?></p>
             <br>
             <hr><?= nl2br($song->text) ?></span>
        <p class="phrase"> <?= nl2br($song->phrase) ?></p>

        <hr><hr>
    <?php endforeach; */?>


</div>

