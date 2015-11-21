/**
 * Created by romanych on 20.11.15.
 */
$(function(){

    var pl_id = 'planet';

    var image = new Image();
    image.src = 'themes/russia2018/images/square_ball.jpg';
    /*image.onload = function(){alert('картинка существует')}; //проверка существование картинки*/
    /*image.onerror = function(){alert('картинка не существует')}; //проверка существование картинки*/

    // загружаем изображение тени и бликов планеты
    var fxShadow = new Image();
    fxShadow.src = 'themes/russia2018/images/sphere.png';


    // определяем длину и высоту элемента canvas
    var width = $('#'+pl_id).width();
    var height = $('#'+pl_id).height();

    // рассчитываем угол вращения планеты
    var beta = 360/900;
    var beta = (beta*Math.PI)/360;
    var l = (Math.sqrt(width*width+width*width))/2;
    var gam = Math.PI - ((Math.PI - (beta * Math.PI)/360)/2) - (Math.PI/4);
    var b = 2*l*Math.sin(beta/2);
    var x = b*Math.sin(gam);
    var y = b*Math.cos(gam);
    var p1 = Math.cos(beta);
    var p2 = Math.sin(beta);

    var canvas = document.getElementById(pl_id);
    var id = canvas.getContext("2d");

    var newMoveWidth = 0;
    var newMoveHeight = 0;

    var drawPl = function(){

        id.clearRect(0, 0, width, height);
        // применяем к нашей планете вращение
        id.transform(p1, p2, -p2, p1, x, -y);
        // рисуем карту с новыми координатами внутри элемента
        id.drawImage(image, newMoveWidth, newMoveHeight, width, height, 0, 0, width, height);
        //добавляем тень и блики
        id.drawImage(fxShadow, 0, 0, width, height);
        // если смещение достигло предела, начинаем сначала
        if (newMoveWidth >= 899.5) newMoveWidth = 0;
        else newMoveWidth = newMoveWidth+0.5; // иначе двигаем карту дальше

    }

    setInterval(drawPl, 50); // запускаем анимацию со скоростью 50 мс.

});
