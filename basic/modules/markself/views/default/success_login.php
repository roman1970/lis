<script>

    function user(id){

        $.ajax({
            type: "POST",
            url: "/markself/default/choosegroup/",
            data: {id : id},
            success: function(html){
                $("html").html(html);

            }

        });
        /*
        $.ajax({
            url: "/markself/default/choosegroup/"+id,
            success: function() {

                    window.location.reload(); // This is not jQuery but simple plain ol' JS

            }
        });

        $.post( "/markself/default/choosegroup/", { id: id } );
         */
        //window.location = "/markself/default/choosegroup/"+id;
    }
</script>


    <button type="button" class="btn btn-lg btn-primary" onclick="user(<?=$id?>)">Заходи - не бойся, выходи - не плач</button>
