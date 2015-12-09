function hideCode() {
    $(".syntaxhighlighter").hide();
    alert("jj");
}


function addingTwoNumbers(){
    $("#code1").show();
    var a = +prompt("Введите первое число", "");
    var b = +prompt("Введите второе число", "");

    alert( a + b );
}

function getDecimal(num) {
    var str = "" + num;
    var zeroPos = str.indexOf(".");
    if (zeroPos == -1) return 0;
    str = str.slice(zeroPos);
    return +str;
}

