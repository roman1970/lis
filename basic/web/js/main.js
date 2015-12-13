function hideCode() {
    $(".syntaxhighlighter").hide();
    alert("jj");
}

//сложение двух чисел
function addingTwoNumbers(){
    alert($(this).html());
    var a = +prompt("Введите первое число", "");
    var b = +prompt("Введите второе число", "");

    alert( a + b );
}

//получение дробной части числа
function getDecimal(num) {
    var str = "" + num;
    var zeroPos = str.indexOf(".");
    if (zeroPos == -1) return 0;
    str = str.slice(zeroPos);
    return +str;
}

//формула Бине
function fibBinet(n) {
    var phi = (1 + Math.sqrt(5)) / 2;
    // используем Math.round для округления до ближайшего целого
    return Math.round(Math.pow(phi, n) / Math.sqrt(5));
}

//Число Фиббонначи
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

//случайного значения в диапазоне от 0 до max
function rand(max){
    alert( Math.random() * max );
}

//случайного значения в диапазоне от min до max
function randInterval(min,max){
    alert( min + Math.random() * (max - min) );
}


