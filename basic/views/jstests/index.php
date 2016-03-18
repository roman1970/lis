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

        <a onclick="putInMultipleNumeric()" class="testLink">15 Умножение численных свойств</a><br>
                <pre class="brush: js;" id="code_15">
               //удвоение численных полей
                function putInMultipleNumeric(){
                    $("#code_15").show();
                    var menu = {
                        width: 200,
                        height: 300,
                        title: "My menu"
                    };

                    multiplyNumeric(menu);
                    alert( "menu width=" + menu.width + " height=" + menu.height + " title=" + menu.title );
                }

                //удваиваем числовые свойства
                function multiplyNumeric(obj){

                    for (var name in obj) {
                        if (isNumeric(obj[name])) {
                            obj[name] *= 2;
                        }
                    }

                    console.log(obj);

                }

                //проверка на число
                function isNumeric(n) {
                    return !isNaN(parseFloat(n)) && isFinite(n)
                }


                </pre>

        <a onclick="lastElOfArray()" class="testLink">16 Последний элемент массива</a><br>
                <pre class="brush: js;" id="code_16">
              function lastElOfArray(){
                   var goods = ['first', 'second', 'third', 'fourth', 'fifth'];
                    alert(goods[goods.length-1]);
                    return goods[goods.length-1];
                }
                </pre>

        <a onclick="randArrayEl()" class="testLink">17 Случайный элемент массива</a><br>
                <pre class="brush: js;" id="code_17">
             function randArrayEl(){
                    $("#code_17").show();
                    var arr = ["Яблоко", "Апельсин", "Груша", "Лимон"];
                    alert(arr[rand(0, arr.length-1)]);
                    return arr[rand(0, arr.length-1)];

                }

                //случайное от min до max
                function rand(min, max){
                    return min + Math.floor(Math.random() * (max + 1 - min));
                }
                </pre>
        <a onclick="sum()" class="testLink">18 Калькулятор суммы</a><br>
                <pre class="brush: js;" id="code_18">
                    function sum(){
                    $("#code_18").show();
                    var arr = [];
                    var p;
                    while (true) {

                        var value = prompt("Введите число", 0);

                        if (value === "" || value === null || isNaN(value)) break;

                        arr.push(+value);
                    }

                    var sum = 0;
                    for (var i = 0; i < arr.length; i++) {
                        sum += arr[i];
                    }
                    alert( sum );

                }
                </pre>
        <a onclick="findTest()" class="testLink">19 Поиск в массиве</a><br>
                <pre class="brush: js;" id="code_19">
                    function findTest(){
                        $("#code_19").show();
                        var array = ["test", 2, 1.5, false];

                        if ([].indexOf) {
                            var find = function(array, value) {
                                return array.indexOf(value);
                            }

                        } else {
                            var find = function(array, value) {
                                for (var i = 0; i < array.length; i++) {
                                    if (array[i] === value) return i;
                                }

                                return -1;
                            }

                        }

                        alert(find(array, "test")); // 0
                        alert(find(array, 2)); // 1
                        alert(find(array, 1.5)); // 2
                        alert(find(array, 0)); // -1

                    }

                </pre>
        <a onclick="truncateArray()" class="testLink">20 Усечение массива</a><br>
                <pre class="brush: js;" id="code_20">
                  //Усечение массива
                    function truncateArray(){
                        $("#code_20").show();
                        var arr = [5, 4, 3, 8, 0];

                        var filtered = filterRange(arr, 3, 5);
                        alert( filtered );
                    }

                    function filterRange(arr, begin, end){
                        var result = [];
                        for (var i = 0; i < arr.length; i++) {
                            if (arr[i] >= a && arr[i] <= b) {
                                result.push(arr[i]);
                            }
                        }
                        return result;

                    }
                </pre>

        <a onclick="eratoPrimes()" class="testLink">21 Решето Эратосфена</a><br>
                <pre class="brush: js;" id="code_21">
                 //Решето Эратосфена
                    function eratoPrimes(){
                        // шаг 1 Создать список последовательных чисел от 2 до n: 2, 3, 4, ..., n.
                        var arr = [];

                        for (var i = 2; i < 100; i++) {
                            arr[i] = true
                        }

                        // шаг 2 Пусть p=2, это первое простое число.
                        var p = 2;

                        do {
                            // шаг 3 ачеркнуть все последующие числа в списке с разницей в p,
                            // т.е. 2*p, 3*p, 4*p и т.д. В случае p=2 это будут 4,6,8....
                            for (i = 2 * p; i < 100; i += p) {
                                arr[i] = false;
                            }

                            // шаг 4 Поменять значение p на первое не зачеркнутое число после p.
                            for (i = p + 1; i < 100; i++) {
                                if (arr[i]) break;
                            }

                            p = i;
                        } while (p * p < 100); // шаг 5 Повторить шаги 3-4 пока p2 < n.

                    // шаг 6 (готово) Все оставшиеся не зачеркнутыми числа – простые.
                    // посчитать сумму
                        var sum = 0;
                        for (i = 0; i < arr.length; i++) {
                            if (arr[i]) {
                                sum += i;
                            }
                        }
                        alert( arr );
                        alert( sum );
                    }
                </pre>

        <a onclick="maxSubSum()" class="testLink">22 Сумма элементов подмассива - медленное решение</a><br>
                <pre class="brush: js;" id="code_22">
                //сумма элементов подмассива - Медленное решение
                //Такое решение имеет оценку сложности O(n2), то есть при увеличении массива в 2 раза алгоритм требует в 4 раза больше времени.
                // На больших массивах (1000, 10000 и более элементов) такие алгоритмы могут приводить к серьёзным «тормозам».
                function getMaxSubSum(arr) {
                    var maxSum = 0; // если совсем не брать элементов, то сумма 0

                    for (var i = 0; i < arr.length; i++) {
                        var sumFixedStart = 0;
                        for (var j = i; j < arr.length; j++) {
                            sumFixedStart += arr[j];
                            maxSum = Math.max(maxSum, sumFixedStart);
                        }
                    }

                    return maxSum;
                }
                //Быстрое решение
                //Будем идти по массиву и накапливать в некоторой переменной s текущую частичную сумму.
                // Если в какой-то момент s окажется отрицательной, то мы просто присвоим s=0. Утверждается,
                // что максимум из всех значений переменной s, случившихся за время работы, и будет ответом на задачу.
                // Докажем этот алгоритм. В самом деле, рассмотрим первый момент времени, когда сумма s стала отрицательной.
                // Это означает, что, стартовав с нулевой частичной суммы, мы в итоге пришли к отрицательной частичной сумме
                // – значит, и весь этот префикс массива, равно как и любой его суффикс имеют отрицательную сумму.
                // Следовательно, от всего этого префикса массива в дальнейшем не может быть никакой пользы:
                // он может дать только отрицательную прибавку к ответу.

                function getMaxSubSumQ(arr) {
                    var maxSum = 0,
                        partialSum = 0;
                    for (var i = 0; i < arr.length; i++) {
                        partialSum += arr[i];
                        maxSum = Math.max(maxSum, partialSum);
                        if (partialSum < 0) partialSum = 0;
                    }
                    return maxSum;
                }


                function maxSubSum() {
                    $("#code_22").show();
                    alert("Медленное решения");
                    alert(getMaxSubSum([-1, 2, 3, -9])); // 5
                    alert(getMaxSubSum([-1, 2, 3, -9, 11])); // 11
                    alert(getMaxSubSum([-2, -1, 1, 2])); // 3
                    alert(getMaxSubSum([1, 2, 3])); // 6
                    alert(getMaxSubSum([100, -9, 2, -3, 5])); // 100
                    alert("Быстрое решение");
                    alert( getMaxSubSumQ([-1, 2, 3, -9]) ); // 5
                    alert( getMaxSubSumQ([-1, 2, 3, -9, 11]) ); // 11
                    alert( getMaxSubSumQ([-2, -1, 1, 2]) ); // 3
                    alert( getMaxSubSumQ([100, -9, 2, -3, 5]) ); // 100
                    alert( getMaxSubSumQ([1, 2, 3]) ); // 6
                    alert( getMaxSubSumQ([-1, -2, -3]) ); // 0
                }
                </pre>

        <a onclick="addCls()" class="testLink">23 Добавить класс в строку-свойство класса</a><br>
                <pre class="brush: js;" id="code_23">
                //Добавление в строку свойства объекта
                    function addCls(){
                        addClass(obj, 'new');
                        addClass(obj, 'open');
                        addClass(obj, 'me');
                        alert(obj.className); // open menu new me
                    }


                    function addClass(obj, cls) {
                        var classes = obj.className ? obj.className.split(' ') : [];

                        for (var i = 0; i < classes.length; i++) {
                            if (classes[i] == cls) return; // класс уже есть
                        }

                        classes.push(cls); // добавить

                        obj.className = classes.join(' '); // и обновить свойство


                    }

                    var obj = {
                        className: 'open menu'
                    };

                </pre>

        <a onclick="getCamelize()" class="testLink">24 Создать CamelCase из дефисного</a><br>
                <pre class="brush: js;" id="code_24">
               //Замена дефисного на camelcase
                    function camelize(str) {
                        var arr = str.split('-');

                        for (var i = 1; i < arr.length; i++) {
                            // преобразовать: первый символ с большой буквы
                            arr[i] = arr[i].charAt(0).toUpperCase() + arr[i].slice(1);
                        }

                        return arr.join('');
                    }

                    function getCamelize() {

                        alert(camelize("background-color")); // backgroundColor
                        alert(camelize("list-style-image")); // listStyleImage
                        alert(camelize("-webkit-transition")); // WebkitTransition
                    }
                </pre>

        <a onclick="remClass()" class="testLink">25 Удаление класса</a><br>
                <pre class="brush: js;" id="code_25">
               //Удаление класса из свойства
                    function removeClass(obj2, cls) {

                        var classes = obj2.className.split(' ');

                        for (var i = 0; i < classes.length; i++) {
                            if (classes[i] == cls) {
                                classes.splice(i, 1); // удалить класс
                                i--; // (*)
                            }
                        }
                        obj2.className = classes.join(' ');

                    }

                    var obj2 = {
                        className: 'open menu menu'
                    }

                    function remClass() {
                        $("#code_25").show();
                        removeClass(obj, 'blabla');
                        removeClass(obj, 'menu');
                        alert(obj.className) // open
                    }

                </pre>
        <a onclick="filterArray()" class="testLink">26 Фильтрация массива в диапазоне передаваемых значений</a><br>
                <pre class="brush: js;" id="code_26">

                    //Фильтация массива
                    function filterRangeInPlace(arr, a, b) {

                        for (var i = 0; i < arr.length; i++) {
                            var val = arr[i];
                            if (val < a || val > b) {
                                arr.splice(i--, 1);
                            }
                        }

                    }

                    function filterArray() {
                        var arr = [5, 3, 8, 1];

                        filterRangeInPlace(arr, 1, 4);
                        alert(arr); // [3, 1]
                    }

                </pre>
        <a onclick="sortArr()" class="testLink">27 Сортировка массива в обратном порядке</a><br>
                <pre class="brush: js;" id="code_27">
                    //сортировка массива в обратном порядке
                    function sortArr(){

                        var arr = [5, 2, 1, -10, 8];
                        alert("Этот массив " + arr + " будет отсортирован в обратном порядке");

                        function compareReversed(a, b) {
                            return b - a;
                        }

                        arr.sort(compareReversed);

                        alert( arr );
                    }
                </pre>
        <a onclick="sortAndCopyArrs()" class="testLink">28 Скопированный и отсортированный массивы</a><br>
                <pre class="brush: js;" id="code_28">
                  //скопировать и отсортировать массив
                        function sortAndCopyArrs() {
                            var arr = ["HTML", "JavaScript", "CSS"];

                            var arrSorted = arr.slice().sort();

                            alert(arrSorted + "скопированный и отсортированный");
                            alert(arr + "данный");
                        }

                </pre>
        <a onclick="randArr()" class="testLink">29 Случайный порядок в массиве</a><br>
                <pre class="brush: js;" id="code_29">
                 //случайный порядок в массиве
                    function randArr() {
                        var arr = [1, 2, 3, 4, 5];

                        function compareRandom(a, b) {
                            return Math.random() - 0.5;
                        }

                        arr.sort(compareRandom);

                        alert(arr); // элементы в случайном порядке, например [3,5,1,2,4]
                    }
                </pre>
        <a onclick="compareObj()" class="testLink">30 Сортировка объектов</a><br>
                <pre class="brush: js;" id="code_30">

                    // Сортировка объектов
                    function compareObj() {
                    // проверка
                        var vasya = {name: "Вася", age: 23};
                        var masha = {name: "Маша", age: 18};
                        var vovochka = {name: "Вовочка", age: 6};

                        var people = [vasya, masha, vovochka];

                        people.sort(compareAge);

                    // вывести
                        for (var i = 0; i < people.length; i++) {
                            alert(people[i].name); // Вовочка Маша Вася
                        }
                    }

                    // Наша функция сравнения
                    function compareAge(personA, personB) {
                        return personA.age - personB.age;
                    }
                </pre>
        <a onclick="cycleOneLinkedList()" class="testLink">31 Вывод списка в цикле</a><br>
                <pre class="brush: js;" id="code_31">
                    //Вывод односвязного списка в цикле
                    function cycleOneLinkedList(){
                        var list = {
                            value: 1,
                            next: {
                                value: 2,
                                next: {
                                    value: 3,
                                    next: {
                                        value: 4,
                                        next: null
                                    }
                                }
                            }
                        };

                        printList(list);
                    }

                    function printList(list) {
                        var tmp = list;

                        while (tmp) {
                            alert( tmp.value );
                            tmp = tmp.next;
                        }

                    }
                </pre>
    </div>



</div>
