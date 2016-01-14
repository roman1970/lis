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
            <a onclick="addingTwoNumbers(this)" class="testLink">1 Сложить два числа</a><br>

                    <pre class="brush: js;" id="code_1">
                        function addingTwoNumbers(){
                            var a = +prompt("Введите первое число", "");
                            var b = +prompt("Введите второе число", "");

                        alert( a + b );
                        }
                    </pre>

        <a onclick="alert(getDecimal(2.3334))" class="testLink">2 Получить дробную часть числа</a><br>

                <pre class="brush: js;" id="code_2">
                    function getDecimal(num) {
                        var str = "" + num;
                        var zeroPos = str.indexOf(".");
                        if (zeroPos == -1) return 0;
                        str = str.slice(zeroPos);
                        return +str;
                    }
                    alert( getDecimal(2.3334) );
                </pre>

        <a onclick="alert(fibBinet(77))" class="testLink">3 Формула Бине для нахождения числа Фибонначи (для числа с номером 77)</a><br>
        <a onclick="alert(fib(77))" class="testLink">более тривиальный подход для нахождения числа Фибонначи (для числа с номером 77)</a><br>

                <pre class="brush: js;" id="code_3">
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

        <a onclick="rand(10)" class="testLink">4 Случайное в диапазоне от 0 до 10</a><br>
                <pre class="brush: js;" id="code_4">
                   function rand(max){
                        alert( Math.random() * max );
                    }
                </pre>
        <a onclick="randInterval(5,10)" class="testLink">5 Случайное в диапазоне от 5 до 10</a><br>
                <pre class="brush: js;" id="code_5">
                 function randInterval(min,max){
                    alert( min + Math.random() * (max - min) );
                    }
                </pre>
        <a onclick="randomInteger(5,10)" class="testLink">6 Случайное целое в диапазоне от 5 до 10</a><br>
                <pre class="brush: js;" id="code_6">
                 function randomInteger(min, max){
                    alert (Math.floor( min + Math.random() * (max - min) ));
                 }
                </pre>
        <a onclick="ucFirst()" class="testLink">7 Делаем первую букву заглавной</a><br>
                <pre class="brush: js;" id="code_7">
                function ucFirst(){
                    var str = prompt('Наберите слово, которое нужно написать с большой буквы', '');
                    if (!str) return str;
                    alert(str[0].toUpperCase() + str.slice(1));
                    return str[0].toUpperCase() + str.slice(1);
                }
                </pre>
        <a onclick="checkSpam()" class="testLink">8 Проверяем строку на наличе viagra, xxx</a><br>
                <pre class="brush: js;" id="code_8">
                function checkSpam(){
                   $("#code_8").show();
                        var str = prompt('Наберите слово', '');
                        var lowerStr = str.toLowerCase();
                            alert(!!(~lowerStr.indexOf('viagra'));
                            alert(~lowerStr.indexOf('xxx')));
                            return !!(~lowerStr.indexOf('viagra') || ~lowerStr.indexOf('xxx'));

                }
                </pre>
        <a onclick="truncate()" class="testLink">9 Укорачиваем строку</a><br>
                <pre class="brush: js;" id="code_9">
                function truncate(){
                    $("#code_8").show();
                        var sent = prompt('Предложение', '');
                        var limit = +prompt('Количество символов', '');

                        if(sent.length < limit) { alert(sent); return sent; }
                        else { alert(sent.slice(0,limit-3)+"..."); return sent.slice(0,limit-3)+"...";}
                    }

                </pre>
        <a onclick="extractCurrencyValue()" class="testLink">10 Выделяем цифры из строки</a><br>
                <pre class="brush: js;" id="code_10">
               function extractCurrencyValue(){
                    $("#code_10").show();
                    var str = prompt('Введите $120', '');
                    alert( str.charCodeAt(0) );
                }

                </pre>

        <a onclick="showPropertiesIsEmptyObj()" class="testLink">11 Проверить, есть ли свойства у объекта</a><br>
                <pre class="brush: js;" id="code_11">
                 function showPropertiesIsEmptyObj() {
                    var schedule = {};

                    alert( isEmpty(schedule) ); // true
                    schedule["8:30"] = "подъём";
                    alert( isEmpty(schedule) ); // false
                }

                function isEmpty(obj){
                    return obj.keys(obj).length ? true : false;
                }

                </pre>
        <a onclick="simpleAnimate()" class="testLink">12 Пример анимации</a><br>
                <pre class="brush: js;" id="code_12">
                function simpleAnimate() {
                    var canvas;
                    var context;

                    window.onload = function() {

                        canvas = document.getElementById("canvas");
                        context = canvas.getContext("2d");
                    // Обновляем холст через 0,02 секунды.
                        setTimeout("drawFrame()", 20);
                    };
                }

                function drawFrame() {
                    var squarePosition_y = 0;
                    var squarePosition_x = 10;
                    // Очищаем холст.
                    context.clearRect(0, 0, canvas.width, canvas.height);
                    // Вызываем метод beginPath(), чтобы убедиться,
                    // что мы не рисуем часть уже нарисованного содержимого холста.
                    context.beginPath();
                    // Рисуем квадрат размером 10х10 пикселов в текущей позиции.
                    context.rect(squarePosition_x, squarePosition_y, 10, 10);
                    context.lineStyle = "black";
                    context.lineWidth = 1;
                    context.stroke();
                    // Перемещаем квадрат вниз на 1 пиксел (где он будет
                    // прорисован в следующем кадре).
                    squarePosition_y += 1;
                    // Рисуем следующий кадр через 20 миллисекунд.
                    setTimeout ("drawFrame()", 20);
                }
                    </pre>
        <?php /*<canvas id="canvas">

        </canvas>
        */ ?>
        <a onclick="sumOfFieldsObjValues()" class="testLink">13 Сумма значений свойств объекта</a><br>
                <pre class="brush: js;" id="code_13">
                 function sumOfFieldsObjValues(){
                        var salarySum;
                        var salaries = {
                            "Вася": 100,
                            "Петя": 300,
                            "Даша": 250
                        };

                        for (var key in salaries){
                            salarySum += salaries[key];
                        }

                        return salarySum;

                    }
                </pre>
        <a onclick="maxSalary()" class="testLink">14 Максимальная зарплата</a><br>
                <pre class="brush: js;" id="code_14">
                function maxSalary(){
                    var salaries = {
                        "Вася": 100,
                        "Петя": 300,
                        "Даша": 250
                    };
                    var max = 0;
                    var maxName = "";
                    for (var name in salaries) {
                        if (max < salaries[name]) {
                            max = salaries[name];
                            maxName = name;
                        }
                    }

                    alert( maxName || "нет сотрудников" );
                }
                </pre>
    </div>



</div>
