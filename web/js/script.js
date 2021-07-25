$(document).ready(function(){
    jQuery.fn.reverse = [].reverse;
	$("html").on( "click", ".to_autor", function() {
        var find = '.comment_body.'+$(this).data("to-autor");
        $('.comment_body').removeClass("found");
        $( 'main' ).find(find).addClass("found");
        $('#bufer_tooltip_content').html('');
        $(this).parents(".comment_body").nextAll().filter(find).each(function( i ) {
            $('#bufer_tooltip_content').append($(this).find('p').html()+'<br><br>');
        });

        $(this).tooltipster('content', $('#bufer_tooltip_content').html());
        $(this).tooltipster('open');
    });
    
	$("html").on( "click", ".showalltext", function() {
        $('.showalltext').removeClass('hidden');
        $(this).addClass('hidden');
        if($('.top_comment small').hasClass('short')){
            $('.top_comment small').removeClass('short');
        }else{
            $('.top_comment small').addClass('short');
        }
    });

	$('.tooltips').tooltipster({
		trigger: 'custom',
        delay: 0,
        contentAsHTML: true,
        side: ['bottom'],
        maxWidth: 800,
        triggerClose: {
            mouseleave: true,
            originClick: true,
            touchleave: true
        }
	});



    $('.toasts').on('click','.removetooltip', function() {
        $(this).parents(".toast").toggleClass('removed');
        var elem = $(this).parents(".toast");
        setTimeout(function(){
            $(elem).remove();
        }, 1000);
    });
    


	var timersec = setInterval(function() {
		$('.loader').html(Number($('.loader').html()) - 1);
	}, 1000);

	var timerajax = setInterval(function() {
        if(typeof video_id == "undefined"){
            var data = { "last_comment": last_comment, "top_comment_id": top_comment_id , "autors_in_list": autors_in_list, "last_time_comment": last_time_comment};
        }else{
            var data = { "last_comment": last_comment, "top_comment_id": top_comment_id , "autors_in_list": autors_in_list, "last_time_comment": last_time_comment, "video_id": video_id};
        }
		$.ajax({
		  type: "POST",
		  url: 'ajax.php',
		  dataType: 'json',
		  data: data,
		  success: function(msg){
		  	if(msg.error == ''){
					if(msg.last_comment){last_comment = msg.last_comment;}
					if(msg.last_time_comment){last_time_comment = msg.last_time_comment;}
					if(msg.autors_in_list){autors_in_list = msg.autors_in_list;}
					if(msg.comments){$(".comment_block").prepend(msg.comments);}

                    if(msg.total_count_comments){
                        total_count_comments = msg.total_count_comments;
                        count_noread_comments = 0;
                        $(".comment_body.noread").each(function(i){
                            count_noread_comments++;
                        });                        
                        $('.top_comment .total_count_comments').html(msg.total_count_comments);
    					document.title = Number(count_noread_comments) + ' из '+ msg.total_count_comments +' :не прочитано.';
                    }

                    if(msg.name_top_comment){$('.top_comment .autorname').html(msg.name_top_comment);}
                    if(msg.avatar_top_comment){$('.top_comment .avatar img').attr('src', msg.avatar_top_comment);}
                    if(msg.time_top_comment){$('.top_comment .time').html(msg.time_top_comment);}
                    
                    if(window.video_id && msg.video_id){
                        video_id = msg.video_id;
                    }
                    
                    if(msg.was_new_video && msg.was_new_video == 'true'){animateFavicon(4);}//animate for new video
                    
					if(msg.comments && msg.comments != null){animateFavicon(1);}//default animate for any message

					if(msg.important_autor && Number(msg.important_autor) > 0){animateFavicon(2);}//important animate for message from important autor
					
					//console.log(msg.hashtopcomment+' - '+hashtopcomment);
					if(msg.hashtopcomment && hashtopcomment != msg.hashtopcomment){
                        hashtopcomment = msg.hashtopcomment;
                        $('.top_comment small').html(msg.text_top_comment);
                        animateFavicon(3);//important animate for message from important autor
                    }

					$('.tooltips:not(.tooltipstered)').tooltipster({
                        trigger: 'custom',
                        delay: 0,
                        contentAsHTML: true,
                        triggerClose: {
                            mouseleave: true,
                            originClick: true,
                            touchleave: true
                        }
					});
                }else{
					animateFavicon(9);
                    $(".error").prepend(msg.error+'<br>');
				}
		  },
		  error: function(msg){
		  	animateFavicon(9);
		  }
		});
		$('.loader').html('20');
	}, 20000);



	idleState = false; // состояние отсутствия
	idleWait = 100; // время ожидания в мс. (1/1000 секунды)

  $(document).bind('mousemove keydown scroll', function(){

    if(idleState == false){
    	idleState = true; 
        $('.comment_body').removeClass('noreadnotifi');
	    setTimeout(function(){ 
				$('.comment_body').removeClass('noread');
				animateFavicon();//turn off animane
				count_noread_comments = 0;
				document.title = '0 из '+ total_count_comments +':не прочитано.';
	      idleState = false; 
	    }, idleWait);
    }

  });
 
  
    $('.comment_block').on('click','.target_to', function() {
        $('#comment').val('@' + $(this).html() + ' ' + $('#comment').val());
    });
  
    $('#do_sendmessage').on('click', function() {
        if($('#comment').val() !=''){
            $.ajax({
                url:     'ajax_sendmessage.php',
                type:     "POST",
                dataType: 'json',
                data: $("#sendcomment").serialize(),
                success: function(response) { //Данные отправлены успешно
                    if(response.result == 'access denied'){
                        $('.errorsendmessage').html('Ошибка. Доступ к api запрещен, повторите процедуру получения прав на странице настроек.');
                    }else{
                        $("#sendcomment")[0].reset();
                        $('.errorsendmessage').html('');
                    }
                },
                error: function(response) { 
                    $('.errorsendmessage').html('Ошибка. Возможно доступ к api запрещен, можно попробовать повторить процедуру получения доступа к api youtube на странице настроек.');
                }
            });
        }else{
            $('.errorsendmessage').html('Сообщение не может быть пустым.');
        }
    });  
  
  
});

function animateFavicon(val) {
	switch(val) {
	  case 1:
            if(animateFaviconst <= 1){//приоритет, если был больше, нельзя понижать
                $('link[rel="shortcut icon"]').attr('href', '/favicon/favicon_animate.ico');
                animateFaviconst = 1;
            }
            if(Cookies.get('nitification') == '2'){
                var textcomment = '';
                var time = 0;
                $('.comment_block .comment_body.noreadnotifi').reverse().each(function(indx, element){
                    //textcomment = textcomment + '<b>' + $(element).find(".username").html() + '</b>' + ' - ' + $(element).find(".data").html() + '<br>' + $(element).find(".comment").html() + '<br>';
                    //textcomment = $(element).find(".username").html() + ' - ' + $(element).find(".data").html() + '\r\n' + $(element).find(".comment").text() + '\r\n\r\n';
                    setTimeout( function(){
                        notify('' + $(element).find(".username").html() + ' в ' + $(element).find(".data").html(), {
                            body: $(element).find(".comment").text(),
                            requireInteraction: true,
                            icon: $(element).find(".avatar_image").attr('src'),
                            onclick: function(e) {},
                            onclose: function(e) {},
                            ondenied: function(e) {}
                        });
                    }, time);
                    time += 400;
                });
                $('.comment_body').removeClass('noreadnotifi');
            }
	    break;
	  case 2:
            if(animateFaviconst <= 2){//приоритет, если был больше, нельзя понижать
                $('link[rel="shortcut icon"]').attr('href', '/favicon/green_din_favicon.ico');
                animateFaviconst = 2;
                $(".toasts").prepend('<div role="alert" aria-live="assertive" aria-atomic="true" class="toast" data-autohide="true" data-delay="10000"><div class="toast-header"><img src="' + $('.comment_block .comment_body.noread.important10:first .avatar_image').attr('src') + '" class="rounded mr-2" alt="..."><strong class="mr-auto">' + $('.comment_block .comment_body.noread.important10:first .username').html() + '</strong><small>' + $('.comment_block .comment_body.noread.important10:first .data').html() + '</small><button type="button" class="removetooltip ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="toast-body">' + $('.comment_block .comment_body.noread.important10:first .comment').html() + '</div></div>');
                $('.toast').toast('show');
            }
            if(Cookies.get('nitification') == '1' || Cookies.get('nitification') == '2'){
                var textcomment = '';
                var time = 0;
                $('.comment_block .comment_body.noread.important10').reverse().each(function(indx, element){
                    //textcomment = textcomment + '<b>' + $(element).find(".username").html() + '</b>' + ' - ' + $(element).find(".data").html() + '<br>' + $(element).find(".comment").html() + '<br>';
                    //textcomment = textcomment + $(element).find(".username").html() + ' - ' + $(element).find(".data").html() + '\r\n' + $(element).find(".comment").text() + '\r\n\r\n';
                    setTimeout( function(){
                        notify('' + $(element).find(".username").html() + ' в ' + $(element).find(".data").html(), {
                            body: $(element).find(".comment").text(),
                            requireInteraction: true,
                            icon: $(element).find(".avatar_image").attr('src'),
                            onclick: function(e) {},
                            onclose: function(e) {},
                            ondenied: function(e) {}
                        });
                    }, time);
                    time += 400;
                });
            }
	    break;
	  case 3:  // new top comment
            if(animateFaviconst <= 3){//приоритет, если был больше, нельзя понижать
                $('link[rel="shortcut icon"]').attr('href', '/favicon/new_top_favicon.ico');
                $(".toasts").prepend('<div role="alert" aria-live="assertive" aria-atomic="true" class="toast" data-autohide="false"><div class="toast-header"><img src="' + $('.top_comment .avatar img').attr('src') + '" class="rounded mr-2" alt="..."><strong class="mr-auto">' + $('.top_comment .autorname').html() + ' - Обновил чат</strong><small>' + $('.top_comment .time').html() + '</small><button type="button" class="removetooltip ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="toast-body">' + $('.top_comment small').html() + '</div></div>');
                $('.toast').toast('show');
                animateFaviconst = 3;
            }
            if(Cookies.get('nitification') == '1' || Cookies.get('nitification') == '2' || Cookies.get('nitification') == '3'){
                var textcomment = '';
                var time = 200;
                    setTimeout( function(){
                        notify($('.top_comment .autorname').html() + ' - Обновил чат', {
                            body: $('.top_comment small').html(),
                            requireInteraction: true,
                            icon: $('.top_comment .avatar img').attr('src'),
                            onclick: function(e) {},
                            onclose: function(e) {},
                            ondenied: function(e) {}
                        });
                    }, time);
            }
	    break;
	  case 4:  // new video
            if(animateFaviconst <= 4){//приоритет, если был больше, нельзя понижать
                $('link[rel="shortcut icon"]').attr('href', '/favicon/new_top_favicon.ico');
                if (!$("div.new_video").length){
                    var dt = new Date();
                    var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
                    $(".toasts").prepend('<div role="alert" aria-live="assertive" aria-atomic="true" class="toast new_video" data-autohide="false"><div class="toast-header"><strong class="mr-auto">На канале вышло новое видео!</strong><small>' + time + '</small><button type="button" class="ml-2 mb-1 close removetooltip" data-dismiss="toast" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="toast-body">Посмотреть новое видео можно по <a href="https://www.youtube.com/watch?v=' + video_id + '">ссылке</a></div></div>');
                    $('.toast').toast('show');
                }
                animateFaviconst = 4;
            }
            if(Cookies.get('nitification') == '1' || Cookies.get('nitification') == '2' || Cookies.get('nitification') == '3'){
                var textcomment = '';
                var time = 200;
                    setTimeout( function(){
                        notify('На канале вышло новое видео!', {
                            body: 'Посмотреть новое видео можно по <a href="https://www.youtube.com/watch?v=' + video_id + '">ссылке</a>',
                            requireInteraction: true,
                            icon: $('.top_comment .avatar img').attr('src'),
                            onclick: function(e) {},
                            onclose: function(e) {},
                            ondenied: function(e) {}
                        });
                    }, time);
            }
	    break;
	  case 9:  // error
            if(animateFaviconst <= 9){//приоритет, если был больше, нельзя понижать
                $('link[rel="shortcut icon"]').attr('href', '/favicon/error_favicon.ico');
                if (!$("div.alert-danger").length){
                    $("main").prepend('<div class="alert alert-danger fade show"><strong>Возникла ошибка в получении данных!</strong>.  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>  </button></div>');                
                }
                animateFaviconst = 9;
            }
            if(Cookies.get('nitification') == '1' || Cookies.get('nitification') == '2' || Cookies.get('nitification') == '3'){
                var textcomment = '';
                var time = 200;
                    setTimeout( function(){
                        notify('Ошибка в получении данных!', {
                            body: 'Неизвестная ошибка произошла во время разбора ответа от сервера, возможно требуется повторная авторизация на сайте.',
                            requireInteraction: true,
                            onclick: function(e) {},
                            onclose: function(e) {},
                            ondenied: function(e) {}
                        });
                    }, time);
            }        
	    break;
	  default:
	   	$('link[rel="shortcut icon"]').attr('href', '/favicon/favicon.ico');
	   	animateFaviconst = 0;
	    break;
	}
}
