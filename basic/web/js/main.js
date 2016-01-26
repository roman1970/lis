function hideCode() {
    $(".syntaxhighlighter").hide();
    alert("jj");
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
