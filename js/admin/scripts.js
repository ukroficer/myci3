$(function(){
	/*скрипт для работы placeholder*/
	$('input[placeholder]').placeholder();

	$('#close').click(function(e) {
        $('#enter_div').fadeOut();
		$('#castle').fadeIn();
    });
	$('#castle').click(function(e) {
        $('#enter_div').fadeIn();
		$('#castle').fadeOut();
    });
	/*end*/

   

});
