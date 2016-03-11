function hideCode() {
    $(".syntaxhighlighter").hide();
    alert("jj");
}

function showText(n){
    $("#text_" + n).show();
}

//1 сложение двух чисел
function addingTwoNumbers(){
    $("#code_1").show();
    var a = +prompt("Введите первое число", "");
    var b = +prompt("Введите второе число", "");

    alert( a + b );
}

//2 получение дробной части числа
function getDecimal(num) {
    $("#code_2").show();
    var str = "" + num;
    var zeroPos = str.indexOf(".");
    if (zeroPos == -1) return 0;
    str = str.slice(zeroPos);
    return +str;
}

//3 формула Бине
function fibBinet(n) {
    $("#code_3").show();
    var phi = (1 + Math.sqrt(5)) / 2;
    // используем Math.round для округления до ближайшего целого
    return Math.round(Math.pow(phi, n) / Math.sqrt(5));
}

//4 Число Фиббонначи
function fib(n) {
    $("#code_3").show();
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

//5 случайного значения в диапазоне от 0 до max
function rand(max){
    $("#code_4").show();
    alert( Math.random() * max );
}

//6 случайного значения в диапазоне от min до max
function randInterval(min,max){
    $("#code_5").show();
    alert( min + Math.random() * (max - min) );
}

//7 случайное целое в диапазоне
function randomInteger(min, max){
    $("#code_6").show();
    alert (Math.floor( min + Math.random() * (max - min) ));
}

//делаем первую букву заглавной
function ucFirst(){
    $("#code_7").show();
    var str = prompt('Наберите слово, которое нужно написать с большой буквы', '');
    if (!str) return str;
    alert(str[0].toUpperCase() + str.slice(1));
    return str[0].toUpperCase() + str.slice(1);
}

//проверка на спам
function checkSpam(){
    $("#code_8").show();
    var str = prompt('Наберите слово', '');
    var lowerStr = str.toLowerCase();
    alert(!!(~lowerStr.indexOf('viagra')));
    alert(~lowerStr.indexOf('xxx'));
    return !!(~lowerStr.indexOf('viagra') || ~lowerStr.indexOf('xxx'));
}

//укорачиваем строку
function truncate(){
    $("#code_9").show();
    var sent = prompt('Предложение', '');
    var limit = +prompt('Количество символов', '');

    if(sent.length < limit) { alert(sent); return sent; }
    else { alert(sent.slice(0,limit-3)+"..."); return sent.slice(0,limit-3)+"...";}

}

//выделяем цифры из смешанной строки
function extractCurrencyValue(){
    $("#code_10").show();
    var str = prompt('Введите $920', '');
    var newStr = '';

    for(var i = 0; i < str.length; i++) {
        if(str.charCodeAt(i) > 40) newStr += str[i];
    }
    alert( newStr );
    return newStr;
}

//есть ли свойства у объекта
function showPropertiesIsEmptyObj() {
    $("#code_11").show();
    var schedule = {};

    alert( isEmpty(schedule) ); // true
    schedule["8:30"] = "подъём";
    alert( isEmpty(schedule) ); // false
}

function isEmpty(obj){
    var counter = 0;
    for (var key in obj) {
        counter++;
    }
    return counter ? true : false;
}

//пример анимации

function simpleAnimate() {
    var canvas = document.getElementById("canvas");
    var context = canvas.getContext("2d");
    var squarePosition_y = 0;
    var squarePosition_x = 10;
   // var c=document.getElementById("myCanvas");
   // var ctx=c.getContext("2d");
    //ctx.fillStyle="red";
    context.fillRect(0,0,300,150);
  //  ctx.clearRect(20,20,100,50);

    // Очищаем холст.
    context.clearRect(0, 0, canvas.width, canvas.height);
    // Вызываем метод beginPath(), чтобы убедиться,
    // что мы не рисуем часть уже нарисованного содержимого холста.
    context.beginPath();
    // Рисуем квадрат размером 10х10 пикселов в текущей позиции.
    context.rect(squarePosition_x, squarePosition_y, 100, 100);
    context.lineStyle = "black";
    context.lineWidth = 1;
    context.stroke();
    // Перемещаем квадрат вниз на 1 пиксел (где он будет
    // прорисован в следующем кадре).
    squarePosition_y += 1;
    // Рисуем следующий кадр через 20 миллисекунд.
    setTimeout("simpleAnimate()", 20);
}

//сумма полей объекта
function sumOfFieldsObjValues(){
    $("#code_13").show();
    var salarySum = 0;
    var salaries = {
        "Вася": 100,
        "Петя": 300,
        "Даша": 250
    };

    for (var key in salaries){
        salarySum += salaries[key];
    }
    alert(salarySum);
    return salarySum;

}

//максимальное  значение поля
function maxSalary(){
    $("#code_14").show();
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

//последний элемент массива
function lastElOfArray(){
    $("#code_16").show();
   var goods = ['first', 'second', 'third', 'fourth', 'fifth'];
    alert(goods[goods.length-1]);
    return goods[goods.length-1];
}

//случайный элемент массива
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

//калькулятор суммы
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

//Поиск в массиве
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
        if (arr[i] >= begin && arr[i] <= end) {
            result.push(arr[i]);
        }
    }
    return result;

}


//Решето Эратосфена
function eratoPrimes(){
    $("#code_21").show();
    var str = 'Простые числа до ста: ';
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
            str += ' ' + i;
        }
    }
    alert( str );
    alert( sum );
}


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

//Добавление в строку свойства объекта
function addCls(){
    $("#code_23").show();
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
    $("#code_24").show();

    alert(camelize("background-color")); // backgroundColor
    alert(camelize("list-style-image")); // listStyleImage
    alert(camelize("-webkit-transition")); // WebkitTransition
}

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
    $("#code_26").show();
    var arr = [5, 3, 8, 1];

    filterRangeInPlace(arr, 1, 4);
    alert(arr); // [3, 1]
}


//сортировка массива в обратном порядке
function sortArr(){
    $("#code_27").show();

    var arr = [5, 2, 1, -10, 8];
    alert("Этот массив " + arr + " будет отсортирован в обратном порядке");

    function compareReversed(a, b) {
        return b - a;
    }

    arr.sort(compareReversed);

    alert( arr );
}

//скопировать и отсортировать массив
function sortAndCopyArrs() {
    $("#code_28").show();

    var arr = ["HTML", "JavaScript", "CSS"];

    var arrSorted = arr.slice().sort();

    alert(arrSorted + " скопированный и отсортированный");
    alert(arr + " данный");
}

//случайный порядок в массиве
function randArr() {
    $("#code_29").show();
    var arr = [1, 2, 3, 4, 5];

    function compareRandom(a, b) {
        return Math.random() - 0.5;
    }

    arr.sort(compareRandom);

    alert(arr); // элементы в случайном порядке, например [3,5,1,2,4]
}