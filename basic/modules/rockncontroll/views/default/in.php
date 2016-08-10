<script>
    $(document).ready(function() {

        $('#dish').autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();
                console.log(term);
                $.getJSON("dishes", function (data) {

                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });

        $("#ate").click(
            function() {
                var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
                var dish = $("#dish").val();
                var measure = $("#measure").val();

                if (dish == '') {alert('Введите название блюда!'); return;}
                if (measure == '') {alert('Введите название блюда!'); return;}

                ate(dish, measure, user);

            });

    });


    function ate(dish, measure, user) {

        $.ajax({
            type: "GET",
            url: "eat",
            data: "dish="+dish+"&measure="+measure+"&user="+user,
            success: function(html){
                $("#summary").html(html);
            }

        });

    }


</script>

<style>
    .center{
        text-align: center;
    }
</style>
<header>
    <div class="logo">
        <h1 class="main_title">Today <?=date('d M Y', time()) ?></h1>
    </div>
</header>
