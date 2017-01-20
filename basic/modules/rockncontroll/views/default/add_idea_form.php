<script>
    var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
    $(document).ready(function() {

        $('#find_idea').autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();
                console.log(term);
                $.getJSON("rockncontroll/default/ideas", function (data) {

                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });


        $(".accord h4:first").addClass("active");

        $(".accord p").hide();

        $(".accord h4").click(function() {

            $(this).next("p").slideToggle("slow").siblings("p:visible").slideUp("slow");


            $(this).toggleClass("active");

            $(this).siblings("h4").removeClass("active");
        });

        $("#make_idea").click(
            function() {

                var txt = $("#evrika").val();

                if (txt == '') {alert('Введите идею!'); return;}

                add(txt, user);

            });

        $("#make_search").click(
            function() {

                var txt = $("#find_idea").val();

                if (txt == '') {alert('Введите идею!'); return;}

                find(txt, user);

            });

        $('#evrika').focus(
            function () {
                $(this).select();
            })

    });

    function add(txt, user) {
        //console.log(txt);

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/project",
            data: "request=" + txt + "&user=" + user,
            success: function (html) {
                $("#res").html(html);

            }

        });
    }

    function find(txt, user) {
        //console.log(txt);

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/project",
            data: "find=" + txt + "&user=" + user,
            success: function (html) {
                $("#res").html(html);

            }

        });
    }



</script>
<style>
    .form-group, p , h4{
        text-align: center;
    }
    h4{
        color: rgb(255, 215, 0);
    }
</style>
<div id="res" class="container">
    <form class="form-inline center" role="form" id="form-ate">
        <div class="form-group">

            <p>
                <input type="text" class="form-control" id="evrika"  placeholder="Кратко идея">

                <button type="button" class="btn btn-success" id="make_idea" >Добавить идею!</button>
            </p>
        </div>
    </form>
    <form class="form-inline center" role="form" id="form-ate">
        <div class="form-group">

            <p>
                <input type="text" class="form-control" id="find_idea"  placeholder="Идея">

                <button type="button" class="btn btn-success" id="make_search" >Найти идею!</button>
            </p>
        </div>
    </form>

</div>