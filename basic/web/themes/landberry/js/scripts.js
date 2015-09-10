
$(document).ready(function(){

	/* прижимаем навигационное меню к верху */

	var offset_top = $('#nav').offset().top;
	var sticky_navigation = function(){
		var scroll_top = $(window).scrollTop(); 

		if (scroll_top > offset_top) { 
			$('#nav').css({ 'position': 'fixed', 'top':0, 'left':0, 'width':'100%'});
		} else {
			$('#nav').css({ 'position': 'relative' }); 
		}   
	};

	sticky_navigation();
	$(window).scroll(function() {
		 sticky_navigation();
	});

/* навигация */

	$(".top").click(function() {
	    $('html, body').animate({
	        scrollTop: (0)
	    }, 600);

	    return false;
	});	

	$(".projects").click(function() {
	    $('html, body').animate({
	        scrollTop: ($("#projects").offset().top-53)
	    }, 600);

	    return false;
	});	

	$(".format").click(function() {
	    $('html, body').animate({
	        scrollTop: ($("#format").offset().top-53)
	    }, 600);

	    return false;
	});	

	$(".cost").click(function() {
	    $('html, body').animate({
	        scrollTop: ($("#cost").offset().top-53)
	    }, 600);

	    return false;
	});	

	$(".contacts").click(function() {
	    $('html, body').animate({
	        scrollTop: ($("#book").offset().top-53)
	    }, 600);

	    return false;
	});	

	$(".book").click(function() {
	    $('html, body').animate({
	        scrollTop: ($("#book").offset().top-53)
	    }, 600);

	    return false;
	});

/* Валидация формы */

	$("#form1").validate({
	            rules:{
	                  name:{
	                      required: true,
	                      minlength: 2,
	                      maxlength: 25,
	                  },

	                  phone:{
	                      required: true,
	                      digits: true
	                  }
	             },
	             messages:{
	                  name:{
	                      minlength: "Имя должно быть не менее 2-х символов",
	                      maxlength: "Максимальное число символо - 25",
	                  },

	                  phone:{
	                      digits: "Введите цифровое значение",
	                  }
	             },
	              submitHandler: function(form) {
	                $.post($(form).attr('action'), $(form).serialize(), function(data)  {
	                        $("#thanks-wrap").fadeIn(300);
	                     }
	                );
	                return false;
	              }
	});

/* Закрываем окно благодарности */

	$("html,body").click(function() {
	     $("#thanks-wrap").fadeOut(300);
	});	


/* устанавливаем дату на 1 день вперед */

	var tomorrow = Date.now() + 60*60*24*1000;
	var date = new Date(tomorrow);

	$('#cost .day').html(date.getDate());
	$('#cost .month').html(date.getMonth() + 1); // месяц с 0
	$('#cost .year').html(date.getFullYear());
/* Количество просмотров */
	

	$( "#from" ).datepicker({
	  minDate: +1,
      dateFormat: 'dd-mm-yy',
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
        var currentDate = new Date();
		var minbookingDate = Math.round(($("#from").datepicker("getDate")-currentDate)/(24*60*60*1000));
		var maxbookingDate = Math.round(($("#to").datepicker("getDate")-currentDate)/(24*60*60*1000));
		var views = (maxbookingDate-minbookingDate)*114000;
		if(maxbookingDate>=0){
			$("#book form p").show();
			$('#amount').html(views);
		}
      }
    });
    $( "#to" ).datepicker({
      minDate: +1,
      dateFormat: 'dd-mm-yy',
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
        var currentDate = new Date();
		var minbookingDate = Math.round(($("#from").datepicker("getDate")-currentDate)/(24*60*60*1000));
		var maxbookingDate = Math.round(($("#to").datepicker("getDate")-currentDate)/(24*60*60*1000));
		var views = (maxbookingDate-minbookingDate)*114000;
		if(minbookingDate>=0){
			$("#book form p").show();
			$('#amount').html(views);
		}
      }
    });

		
	    

});

