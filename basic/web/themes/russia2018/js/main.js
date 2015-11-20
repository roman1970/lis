/**
 * Created by romanych on 20.11.15.
 */
$(function(){

    var pl_id = 'planet';

    var image = new Image();
    image.src = 'themes/russia2018/images/square_ball.jpg';
    /*image.onload = function(){alert('картинка существует')}; //проверка существование картинки*/
    /*image.onerror = function(){alert('картинка не существует')}; //проверка существование картинки*/


    // определяем длину и высоту элемента canvas
    var width = $('#'+pl_id).width();
    var height = $('#'+pl_id).height();

    var canvas = document.getElementById(pl_id);
    var id = canvas.getContext("2d");

    var newMoveWidth = 0;
    var newMoveHeight = 0;

    var drawPl = function(){

        id.clearRect(0, 0, width, height);
        // рисуем карту с новыми координатами внутри элемента
        id.drawImage(image, newMoveWidth, newMoveHeight, width, height, 0, 0, width, height);

        if (newMoveWidth >= 899.5) newMoveWidth = 0; // если смещение достигло предела, начинаем сначала
        else newMoveWidth = newMoveWidth+0.5; // иначе двигаем карту дальше

    }

    setInterval(drawPl, 50); // запускаем анимацию со скоростью 50 мс.

});
