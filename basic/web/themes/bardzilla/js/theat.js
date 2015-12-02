/*$(document).ready(function() {


    $('#atho').click(function() {
    $("#play").load("bardzilla/default/showrymes");
        if (!last) {
        y = document.getElementById("main");
        var last = y.lastChild;
        last.parentNode.removeChild(last);
}
});


        $('#au').click(function() {
        $("#play").load("bardzilla/default/showaudio");
        if (!last) {y = document.getElementById("main");
        var last = y.lastChild;
        last.parentNode.removeChild(last);
}

});

        $('#site').click(function() {
        $("#play").load("conn3.html");
        if (!last) {y = document.getElementById("main");
        var last = y.lastChild;
        last.parentNode.removeChild(last);
}

});
        $('#con').click(function() {
        $("#play").load("conn.html");
        if (!last) {
        y = document.getElementById("main");
        var last = y.lastChild;
        last.parentNode.removeChild(last); }



});
        $('#con2').click(function() {
            $("#play").load("audio_tb.php");
        if (!last) {
        y = document.getElementById("main");
        var last = y.lastChild;
        last.parentNode.removeChild(last); }



});
        $('#pho').click(function() {
        $("#play").load("bez_pokup.html");
        if (!last) {
        y = document.getElementById("main");
        var last = y.lastChild;
        last.parentNode.removeChild(last); }


});

        $('#more').click(function() {
        num = $(this).data('num');    
        $("#play").load("stihi/authors_"+ num +".php");
        if (!last) {
        y = document.getElementById("main");
        var last = y.lastChild;
        last.parentNode.removeChild(last); }


});

});
*/
        var index = 0;
        var el;
        var txt;
        i = 0;
        var year = 2000;
        var im = 0;

        dt = new Array("#000", "#fff", "#000", "#e4a001");
        function next_cl()
                {

                document.getElementById("tel").style.color = dt[i++];
                        if (i > dt.length)
                        i = 0;
                        setTimeout("next_cl()", 10000);
                        }



        function onPhotoClick() {
        var shadow = document.getElementById('shadow');
                var photo = document.getElementById('photo');
                shadow.style.display = "block"; //показываем тень
                photo.style.display = "block"; //показываем картинку
                photo.style.backgroundImage = 'url("' + this.src + '")';
                }

        function hidePhoto() {
        var shadow = document.getElementById('shadow');
                var photo = document.getElementById('photo');
                shadow.style.display = ""; //сбрасываем
                photo.style.display = ""; //сбрасываем
                }

        function getPhotoSmaller() {
        var myPic = document.getElementById("tb");
                var normalWidth = 100;
                if (myPic.width > normalWidth) {
//Увеличиваем размеры картинки на 10%
        myPic.width *= 0.9;
                myPic.height *= 0.9;
                setTimeout("getPhotoSmaller()", 50);
        }

        myPic.onclick = resizePicture;
                }

        function resizePicture() {
        var myPic = document.getElementById("tb");
                var normalWidth = 340;
                if (myPic.width < normalWidth) {
//Увеличиваем размеры картинки на 10%
        myPic.width *= 1.1;
                myPic.height *= 1.1;
                setTimeout("resizePicture()", 50);
        }
        myPic.onclick = getPhotoSmaller; /*по клику уменьшаем снова*/
                }

        function getNextPhrase() {
        var phrase = document.getElementById("phrase");
                var last = phrase.lastChild;
                last.parentNode.removeChild(last);
                var p = document.createElement("P");
                if (phr.length > index)
                index++;
                else {
                index = 0;
                }


        var str = phr[index];
                if (!str)
                str = phr[0];
                var text = document.createTextNode(str);
                el = phrase.appendChild(p);
                el.className = "sl";
                el.appendChild(text);
                setTimeout("getNextPhrase()", 10000);
                }
  
/* Меняем шапку через 15 секунд*/
  function getNextHead() {
        var head = document.getElementById("phot_h");
                var last = head.lastChild;
                last.parentNode.removeChild(last);
                var imgig = document.createElement("IMG");
                
               if (phot_h.length - 1 > im)
                im++;
                else {
                im = 0;
                }


        var pth = phot_h[im];
                if (!pth)
                pth = phot_h[0];
               
      
                imgig.src = "../Img/" + phot_h[im];
                imgig.width = 1100;
                imgig.height = 100;
                head.appendChild(imgig);
                
                setTimeout("getNextHead()", 15000);
                }     
                
/* Меняем левую картинку */                
 function getNextPhotoLeft() {
        var lef = document.getElementById("rom");
                var last = lef.lastChild;
                last.parentNode.removeChild(last);
              var imgig = document.createElement("IMG");
                
               if (phot_l.length - 1 > im)
                im++;
                else {
                im = 0;
                }


        var pth = phot_l[im];
                if (!pth)
                pth = phot_l[0];
               
      
                imgig.src = "themes/bardzilla/Img/" + phot_l[im];
                imgig.width = 330;
                imgig.height = 320;
                el = lef.appendChild(imgig);
                
                
                setTimeout("getNextPhotoLeft()", 8000);
                }     
                               
            
/* Меняем правую картинку */
function getNextPhotoRight() {
        var lef = document.getElementById("mish");
                var last = lef.lastChild;
                last.parentNode.removeChild(last);
              var imgig = document.createElement("IMG");
             
               if (phot_l.length - 1 > im)
                im++;
                else {
                im = 0;
                }


        var pth = phot_l[im];
                if (!pth)
                pth = phot_l[0];
               
      
                imgig.src = "themes/bardzilla/Img/" + phot_l[im];
                imgig.width = 330;
                imgig.height = 320;
                el = lef.appendChild(imgig);
                
                
                setTimeout("getNextPhotoRight()", 10000);
                }                      

function getTemp(){
        
                if (year < 2014) {
                    $("#temp").load("temp.php", { y: year}, function(data){
                    var sent= data;
                    var tem = document.getElementById("temp");
                    var last = tem.lastChild;
                    last.parentNode.removeChild(last);
                    var p = document.createElement("P");
                    var str = sent;
                    var text = document.createTextNode(str);
                    el = tem.appendChild(p);
                    el.className = "sl";
                    el.style.fontSize = "18px";
                    el.appendChild(text);
                    year++;
                    setTimeout("getTemp()", 5000);
                
                
                 });
            }
        else {
              year = 2000;
              getTemp();
        }

    
        }


        function getNextTemp() {
        var phrase = document.getElementById("temp");
                var last = phrase.lastChild;
                last.parentNode.removeChild(last);
                var p = document.createElement("P");
                if (temp.length > i)
                i++;
                else {
                i = 0;
                }


        var str = temp[i];
                if (!str)
                str = temp[0];
                var text = document.createTextNode(str);
                el = phrase.appendChild(p);
                el.className = "sl";
                el.appendChild(text);
                setTimeout("getNextTemp()", 10000);
                }

        window.onload = function() {

            $.getJSON( "bardzilla/default/getphrases/", function( data ) {
              phr = data;
                var phrase = document.getElementById("phrase");
                        var p = document.createElement("P");
                        var str = phr[index];
                        var text = document.createTextNode(str);
                        el = phrase.appendChild(p);
                        el.className = "sl";
                        txt = el.appendChild(text);
                        setTimeout("getNextPhrase()", 10000);

                        getNextPhotoLeft();
                        getNextPhotoRight();
                        getTemp();
                }, "json" );
        };


        function getContent(block,cat,page) {
                if(page === undefined) page = '';

                $('#' + block).click(function () {
                    $("#play").load("bardzilla/default/show/"+cat+page);
                });

        }


        function setCount(id) {
            alert(id);
            $('#uu').load("bardzilla/default/counter/"+id);
        }




