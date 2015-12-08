<?php

/* @var $this yii\web\View */

$this->title = 'Тесты';
?>
<script src="https://js.cx/test/libs.js"></script>

<script type="text/javascript">
    SyntaxHighlighter.all()
</script>
<div class="site-index">

    <div class="jumbotron">
        <h1>Тесты</h1>
            <a href="/jstests/functions?n=pow">Функция возведения в степень pow</a>
        <h1>Примеры</h1>
            <a onclick="addingTwoNumbers()" class="testLink">Сложить два числа</a>

                <pre  class="brush: js;">
                    function addingTwoNumbers(){
                        var a = +prompt("Введите первое число", "");
                        var b = +prompt("Введите второе число", "");

                    alert( a + b );
                    }
                </pre>

    </div>


</div>
