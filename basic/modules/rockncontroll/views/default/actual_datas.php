
<table class="table_data">
    <tbody>
    <tr>
        <td>Y</td>
        <td>T</td>
        <td>W</td>
        <td>O</td>
        <td>S</td>
        <td>I</td>
    </tr>
    <tr>
        <td>2016</td>
        <td><?= $kt ?></td>
        <td><?= $we ?></td>
        <td><?= round($avg_oz) ?></td>
        <td><?= round($avg_spent_day) ?></td>
        <td><?= round($avg_incomes_day) ?></td>
    </tr>
    <tr>
        <td>2017</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
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
