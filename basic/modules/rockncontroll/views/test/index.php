<script>
var user = <?= (isset($user->id)) ? $user->id : 8 ?>;

function testController(user, controller_str) {
    $.ajax({
        type: "GET",
        url: "rockncontroll/test/"+controller_str+"/",
        data: "user="+user,
        success: function(html){
            $("#summary").html(html);
        }

    });


$("#show_menu").show();
$("#summary").show();
$("#test_menu").hide();

}

</script>
<hr>
<div id="test_menu">

<?php  foreach ($tests as $test): ?>

    <button type="button" class="btn btn-success btn-lg btn-block" onclick="testController(user,'klavaro')"><?= $test->name ?></button>

<?php endforeach; ?>
    
</div>
    