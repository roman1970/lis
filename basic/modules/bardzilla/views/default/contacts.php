<script>


    $(document).ready(function() {
        var name = $("#nm");
        var email = $("#em");
        var tel = $("#tl");
        var text = $("#tx");


        var k = false;
        $("#statusMess").ajaxSuccess(
            function() {
                if (k == true) {
                    $("#send").hide();
                    $(this).text("Сообщение удачно отправлено!");
                }
            }
        );
        $("#send").click(
            function() {

                sendMess(text.val(), name.val(), email.val(), tel.val());
            });
        $("#statusMess").ajaxError(
            function() {

                $(this).text("Сообщение не отправлено!");
                $("#send").show();
            }
        );
        $("#send").ajaxStart(
            function() {
                if (k === true) {
                    $(this).hide();
                    k = false;
                }
            });

        function sendMess(text, name, email, tel) {
            var subj = "Хочу участвовать в проекте";

            //Валидация
            if (name === "") {
                alert("Введите имя");
                return false;
            }
            var regVL = /^[0-9\-\_]{2,25}$/;
            var result = tel.match(regVL);
            if (!result) {
                alert("Введите телефон, на который мы Вам позвоним");
                return false;
            }

            if (email === "") {
                alert("Вы не ввели email");
                return false;
            } else {
                var regV = /^[A-Za-z0-9\-\_]{2,15}\@[A-Za-z0-9\-\_]{2,10}\.[A-Za-z0-9\-\_]{2,4}$/;
                var result_e = email.match(regV);
                if (!result_e) {
                    alert("Email не корректен");
                    return false;
                }
            }
            if (text === "") {
                alert("Вы не ввели сообщение");
                return false;
            } else {
                var regTx = /^[\s\S]{0,80}$/;
                var result_tx = text.match(regTx);
                if (!result_tx) {
                    alert("текст мог бы быть и покороче");
                    return false;
                }
            }

            $.ajax({
                type: "GET",
                url: "bardzilla/default/contacts/",
                data:({name:name,email:email,tel:tel,text:text}),
                cache: false,
                success: function(response){
                    if(response)  k = true;
                    else k = false;
                }
            });



        }


    });



</script>

<div class='content'>

    <p >Сообщите о Вашем  <br />желании поучаствовать<br />
        в нашем не совсем <br /> обычном проекте <br />
        Ваше имя:<br /><input type='text' id="nm"  size="30"/><br />
        Ваш email:<br /> <input type='text' id="em" size="30"/><br />
        Ваш телефон: <br /><input type='text' id="tl" size="30"/></p><br />
    <textarea id="tx" rows="10" cols="28" style="border-radius:10px;"></textarea><br />
    <div id="text_contakt">



        <button id="send" >Отправить сообщение</button>
        <p style="color: #444" id="statusMess"></p>


    </div>

</div>

<br />
