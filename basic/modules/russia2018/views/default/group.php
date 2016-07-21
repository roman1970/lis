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
                    url: "russia2018/default/makep/",
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
        padding: 0;
        height: 33px;
        text-align: center;
    }

    table > tbody > tr > td{
        padding: 0;
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
                            <td><p class="team"><?= $match->tournament ?><br><?= $match->date  ?> </p>
                                <button class="btn btn-success" id="prognose_<?=$i ?>" onclick="prognos(<?=$match->id?>, <?=$i?>)" >Прогноз!</button>
                                <p id="res_<?=$i?>"></p>

                            </td>

                            <td><p class="team"><?= substr($match->host, 0, 31) ?></p>
                                <input type='text' class="form-control" id="host_g_<?=$i ?>"  />


                            </td>
                            <td><p class="team"><?= $match->guest ?></p>
                                <input type='text' class="form-control" id="guest_g_<?=$i ?>" />
                            </td>


                        </tr>

                    <?php $i++; endforeach; ?>
                <?php endif; ?>


        </tbody>
    </table>

</div>
