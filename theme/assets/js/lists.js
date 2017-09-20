$(function(){
	$('.right').click(function(){
	  $('.').html('<input type="text" name="">');
	});
  });
  
jQuery(function($){
    $('.list_content').click(function(){
        if(!$(this).hasClass('on')){
            $(this).addClass('on');
            var txt = $(this).text();
            $(this).html('<input type="text" value="'+txt+'" />');
            $('.list_content > input').focus().blur(function(){
                var inputVal = $(this).val();
                if(inputVal===''){
                    inputVal = this.defaultValue;
                };
                $(this).parent().removeClass('on').text(inputVal);
            });
        };
    });
});