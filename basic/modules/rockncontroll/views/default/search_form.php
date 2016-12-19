<script>
    var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
    $(document).ready(function() {


        $("#search").click(
            function() {

                var txt = $("#text").val();

                if (txt == '') {alert('Введите текст!'); return;}

                find(txt, user);

            });

        $('#text').focus(
            function () {
                $(this).select();
            })
       
    });

    function find(txt, user) {

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/search",
            data: "text=" + txt + "&user=" + user,
            success: function (html) {
                $("#res").html(html);

            }

        });
    }



</script>
<style>
    .form-group{
        text-align: center;
    }
</style>
<div class="container">
    <form class="form-inline center" role="form" id="form-ate">
        <div class="form-group">

            <p>
                <input type="text" class="form-control" id="text"  placeholder="Что найти">

                <button type="button" class="btn btn-success" id="search" >Найти!</button>
            </p>
            <div id="res"></div>
        </div>
    </form>

</div>
