<script>

    function prognos(match,i){

        var host_g = $("#host_g_"+i).val();
        var guest_g = $("#guest_g_"+i).val();

        //Валидация
        if (host_g  === "" || guest_g === "") {
            alert("Введите счет");
            return false;
        }


        var user = <?= (isset($user->id)) ? $user->id : 1 ?>;

            if(host_g && guest_g){
                $.ajax({
                    type: "GET",
                    url: "russia2018/default/match/",
                    data: "host_g="+host_g+"&guest_g="+guest_g+"&user="+user+"&match="+match,
                    success: function(res){
                        $("#prognose_"+i).hide();
                        $("#res_"+i).html(res);
                    }

                });
            }
        else alert("Введите счёт прогнозируемого матча!");



        return true;


    }

</script>

<style>
    .form-control{
        width: auto;
        display: inline;
    }
    .table > tbody > tr > td{
        vertical-align: middle;
        text-align: center;
    }
    .team {
        font-size: 20px;
    }
    .form-group {
        margin-bottom: 0;
    }
</style>

        <?php  $i = 0;
            if(count($match_list) < 1) : ?> 

                <div class="view" style="color: white; text-align: center" ><h3>Нечего прогнозировать!</h3>
             <?php else : ?>

                    <div class="view">

                        <table class="table">
                            <tbody>


                    <?php foreach ($match_list as $match) :  ?>

                        <tr>
                            <td><p class="team"><?= $match->date  ?></p></td>
                            <td><p class="team"><?= $match->tournament ?></p></td>
                            <td><p class="team"><?= $match->host ?></p>
                                <input type='text' class="form-control" id="host_g_<?=$i ?>" size="2" />
                            </td>
                            <td><p class="team"><?= $match->guest ?></p>
                                <input type='text' class="form-control" id="guest_g_<?=$i ?>" size="2" />
                            </td>


                            <td>
                                <button class="btn btn-primary" id="prognose_<?=$i ?>" onclick="prognos(<?=$match->id?>, <?=$i?>)" >Прогноз!</button>
                                <p id="res_<?=$i?>"></p>

                            </td>
                        </tr>

                    <?php $i++; endforeach; ?>
                <?php endif; ?>


        </tbody>
    </table>

</div>
