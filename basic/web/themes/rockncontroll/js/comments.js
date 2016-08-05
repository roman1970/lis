

/*Симуляция сна*/
function sleep(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds){
            break;
        }
    }
}

function setCookie(name, value, options) {
    options = options || {};

    var expires = options.expires;

    if (typeof expires == "number" && expires) {
        var d = new Date();
        d.setTime(d.getTime() + expires * 1000);
        expires = options.expires = d;
    }
    if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
    }

    value = encodeURIComponent(value);

    var updatedCookie = name + "=" + value;

    for (var propName in options) {
        updatedCookie += "; " + propName;
        var propValue = options[propName];
        if (propValue !== true) {
            updatedCookie += "=" + propValue;
        }
    }

    document.cookie = updatedCookie;
}

function addComment(name, body) {

    //Валидация
    if (name === "") {
        alert("Введите Имя или перезагрузите страницу");
        return false;
    }

    if (body === "") {
        alert("Введите Текст");
        return false;
    }


    $.ajax({
        type: "GET",
        url: "/krokodile/default/addcomment/",
        data: "name="+name+"&body="+body,
        success: function(html){
            $("#base").html(html);
        }

    });

}
