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
    var viagra = "viagra";

    alert(str.length);
    for(var n = 0; n < str.length; n++) {
        if( str[n].toLowerCase().indexOf(viagra[n]) == -1 ) {
            alert("spam!");
            return false;
        }
        //другое решение
        //var lowerStr = str.toLowerCase();
        //return !!(~lowerStr.indexOf('viagra') || ~lowerStr.indexOf('xxx'));
    }

    return true;
}


