<style>
    .center, h3{
        text-align: center;
        color: rgb(255, 215, 0);

    }
    .table > tbody > tr > td{
        vertical-align: middle;
        font-size: 8px;
        color: rgb(255, 215, 0);
        word-break: break-all;
    }

    h3{
        color: rgb(255, 215, 0);
    }
    .glyphicon {
        color: gold !important;
    }

    img{
        width: 100px;
    }
    .red{
        background-color: red;
    }
    .green{
        background-color: green;
    }
    .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td{
        padding: 0;
    }
    .table{
        padding-bottom: 5px;
    }
</style>

<div id="sum_play">

    <form class="form-inline center" role="form" id="form-album">
        <div class="form-group">
            <h3>Пятна года!</h3>
            <p>

                <input type="text" class="form-control" id="deals"  placeholder="Дело"><br>
                <input type="text" class="form-control" id="year"  placeholder="Год в формате ГГГГ"><br>

                <button type="button" class="btn btn-success" id="show_year_points" >Показать!</button>
            </p>
        </div>
    </form>

    <table class="table table-responsive">
        <tbody id="insert_table">

        </tbody>
    </table>

</div>
<script>

    var user = <?= (isset($user->id)) ? $user->id : 8 ?>;

    $(document).ready(function() {
        // console.log(songs[0]);

        $('#deals').autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();

                $.getJSON("rockncontroll/default/deals-list", function (data) {
                    console.log(data);
                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });

        $("#show_year_points").click(
            function () {

                var deal = $("#deals").val();
                var year = $("#year").val();


                if (deal === '' || year === '') {
                    alert('Введите дело и год!');
                    return;
                }


                get_year_points(deal, year, user);


            });
    });


    function get_year_points(deal, year, user) {

        $.getJSON("rockncontroll/default/year-point/?deal="+deal+"&year="+year+"&user="+user, function (data) {
            ss = data;

            var marks = [];

            for (iter = 0; iter < Object.keys(ss).length; iter++){
                //console.log(i);
                marks.push(ss[iter]);
            }

            // console.log(marks);
            getPanel(marks, year, deal);

        }, "json");
    }

    function getPanel(array_rows, year, deal) {

        var i;
        var sum = '<tr><td colspan="30">'+year+' - '+deal+'</td></tr><tr>';
        var m = 1;

        for(i=1;i<array_rows.length;i++) {

            if(i === 31+1 || i === 31+28+1 || i === 31+28+31+1 || i === 31+28+31+30+1
                || i === 31+28+31+30+31+1 || i === 31+28+31+30+31+30+1 || i === 31+28+31+30+31+30+31+1 || i === 31+28+31+30+31+30+31+31+1
                || i === 31+28+31+30+31+30+31+31+30+1  || i === 31+28+31+30+31+30+31+31+30+31+1
                || i === 31+28+31+30+31+30+31+31+30+31+30+1 || i === 31+28+31+30+31+30+31+31+30+31+30+31+1) {sum += '<tr>'; m=1}

            if(array_rows[i]) sum += '<td class="red">'+m+'</td>';
            else sum += '<td class="green">'+m+'</td>';
            m++;

        }
        sum += '</tr>';

        $("#insert_table").append(sum);

    }





</script>



