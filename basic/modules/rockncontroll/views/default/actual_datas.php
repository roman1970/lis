
<table class="table_data">
    <tbody>
    <tr>
        <td>T</td>
        <td>W</td>
        <td>O</td>
        <td>S</td>
        <td>I</td>
    </tr>


    <tr>
        <td><?= $kt ?></td>
        <td><?= $we ?></td>
        <td><?= $avg_oz ?></td>
        <td><?= $avg_spent_day ?></td>
        <td><?= $avg_incomes_day ?></td>
    </tr>



    </tbody>
</table>
<div id="rand_item"></div>
<script>
        var h;
        setInterval(function () {
            $.ajax({
                type: "GET",
                url: "rockncontroll/default/rand-item/",
                success: function(html){
                    $("#rand_item").html(html);
                    h = html;
                }

            });

        }, 20000);
        $('#current_task').mouseover(function() {

            $("#stop_item_block").parent().show();
            $("#stop_item_block").html(h);
        });
        $('#stop_item_block').mouseover(function() {
            $("#stop_item_block").parent().hide();

        });

</script>
