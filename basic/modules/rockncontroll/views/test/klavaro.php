<script>
    $(document).ready(function() {

        $('#cat').autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();
                console.log(term);
                $.getJSON("rockncontroll/test/klavaros-cats", function (data) {

                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });
        $('#eng_ru').autoComplete({
            minChars: 2,
            source: function (term, suggest) {
                term = term.toLowerCase();
                console.log(term);
                $.getJSON("rockncontroll/test/klavaros-cats", function (data) {

                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });


        $("#done_test").click(
            function() {

                var user = <?= (isset($user->id)) ? $user->id : 8 ?>;

                var presize = $("#presize").val();
                var speed = $("#speed").val();
                var eng_ru = $("#eng_ru").val();
                var cat = $("#cat").val();


                if (presize == '') {
                    alert('Введите точность!');
                    return;
                }

                if (speed == '') {
                    alert('Введите скорость!');
                    return;
                }

                if (eng_ru == '') {
                    alert('Введите раскладку клавиатуры eng или ru!');
                    return;
                }

                if(cat == '') cat = 'eng';

                make_test_klavaro(presize, speed, user, eng_ru, cat);


            });


    });


    function make_test_klavaro(presize, speed, user, eng_ru, cat) {


        $.ajax({
            type: "GET",
            url: "rockncontroll/test/klavaro",
            data: "presize="+presize+"&speed="+speed+"&user="+user+"&eng_ru="+eng_ru+"&cat="+cat,
            success: function(html){
                $("#resp").html(html);

            }

        });

    }


</script>

<style>
    .center, h3{
        text-align: center;
    }
</style>

<div class="container">
    <form class="form-inline center" role="form" id="form-ate">
        <div class="form-group">
            <h3>Прошёл?</h3>
            <p>
                <input type="text" class="form-control" id="presize"  placeholder="Точность"><br>
                <input type="text" class="form-control" id="speed"  placeholder="Слов в минуту"><br>
                <input type="text" class="form-control" id="eng_ru"  placeholder="Раскладка"><br>
                <input type="text" class="form-control" id="cat"  placeholder="Урок"><br>

                <button type="button" class="btn btn-success" id="done_test" >Прошёл!</button>
            </p>
        </div>
    </form>

</div>
<div id="resp"></div>