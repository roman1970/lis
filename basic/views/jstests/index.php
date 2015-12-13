<?php

/* @var $this yii\web\View */

$this->title = 'Тесты';
?>
<script src="https://js.cx/test/libs.js"></script>
<script type="text/javascript">
    $(".syntaxhighlighter").hide();
</script>
<script type="text/javascript">
    SyntaxHighlighter.all()
</script>
<div class="site-index">

    <div class="jumbotron">
        <h1>Тесты</h1>
            <a href="/jstests/functions?n=pow">Функция возведения в степень pow</a>
        <h1>Примеры</h1>
            <a onclick="addingTwoNumbers(this)" class="testLink">Сложить два числа</a>

                    <pre class="brush: js;">
                        function addingTwoNumbers(){
                            var a = +prompt("Введите первое число", "");
                            var b = +prompt("Введите второе число", "");

                        alert( a + b );
                        }
                    </pre>

        <a onclick="alert(getDecimal(2.3334))" class="testLink">Получить дробную часть числа</a>

                <pre class="brush: js;">
                    function getDecimal(num) {
                        var str = "" + num;
                        var zeroPos = str.indexOf(".");
                        if (zeroPos == -1) return 0;
                        str = str.slice(zeroPos);
                        return +str;
                    }
                    alert( getDecimal(2.3334) );
                </pre>

        <a onclick="alert(fibBinet(77))" class="testLink">Формула Бине для нахождения числа Фибонначи (для числа с номером 77)</a><br>
        <a onclick="alert(fib(77))" class="testLink">более тривиальный подход для нахождения числа Фибонначи (для числа с номером 77)</a>

                <pre class="brush: js;">
                    function fibBinet(n) {
                        var phi = (1 + Math.sqrt(5)) / 2;
                        // используем Math.round для округления до ближайшего целого
                        return Math.round(Math.pow(phi, n) / Math.sqrt(5));
                        }

                        function fib(n) {
                        var a = 1,
                        b = 0,
                        x;
                        for (i = 0; i < n; i++) {
                        x = a + b;
                        a = b
                        b = x;
                        }
                        return b;
                        }


                        alert( fibBinet(77) ); // 5527939700884755
                        alert( fib(77) );      // 5527939700884757, не совпадает!
                    }
                </pre>

        <a onclick="rand(10)" class="testLink">Случайное в диапазоне от 0 до 10</a>
                <pre class="brush: js;">
                   function rand(max){
                        alert( Math.random() * max );
                    }
                </pre>
        <a onclick="randInterval(5,10)" class="testLink">Случайное в диапазоне от 5 до 10</a>
                <pre class="brush: js;">
                 function randInterval(min,max){
                    alert( min + Math.random() * (max - min) );
                    }
                </pre>

    </div>



</div>
