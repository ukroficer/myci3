$(document).ready(function() {
	/*$(document).on('click' , '.toogleAside' , function(event) {
		event.preventDefault();
		_this = $(this);
		_body = $('body');
		_thIco = _this.find('i')
		if (_thIco.hasClass('fa-arrow-circle-left')) {
			_thIco.removeClass('fa-arrow-circle-left').addClass('fa-arrow-circle-right ');
		} else {
			_thIco.addClass('fa-arrow-circle-left').removeClass('fa-arrow-circle-right ');
		}
		if (_body.hasClass('hidden-menu')) {
			_body.removeClass('hidden-menu');
		} else {
			_body.addClass('pre-hidden-menu');
			setTimeout(function() {
				_body.addClass('hidden-menu').removeClass('pre-hidden-menu');
			},50)
		}
			
		
		
	})*/

	//  стилизация селектов, радио кнопок и чекбоксов
	setTimeout(function(){
		$(".select").chosen({disable_search: true});
		$('table.dataTable').wrap("<div class='scroll_wrp'><div class='table_wrapper'></div></div>");
	},100);


//	toogle_menu
	// $(document).on('click', '.toogle_menu', function(event) {
	// 	event.preventDefault();
	// 	$('body').toggleClass('menu_close');
	// });

	// $(document).on('click' , '#toogleAside' , function(event) {
	// 	event.preventDefault();
	// 	_this = $(this);
	// 	_body = $('body');
	// 	_thIco = _this.find('i')
	// 	if (_thIco.hasClass('fa-arrow-circle-left')) {
	// 		_thIco.removeClass('fa-arrow-circle-left').addClass('fa-arrow-circle-right ');
	// 	} else {
	// 		_thIco.addClass('fa-arrow-circle-left').removeClass('fa-arrow-circle-right ');
	// 	}
	// 	if (_body.hasClass('menu_close')) {
	// 		_body.removeClass('menu_close');
	// 	} else {
	// 		_body.addClass('pre-hidden-menu');
	// 		setTimeout(function() {
	// 			_body.addClass('menu_close').removeClass('pre-hidden-menu');
	// 		},50)
	// 	}
			
		
		
	// })


//	menu
	$('#left-side-panel').find('li a').each(function() {
		_this = $(this);
		if (_this.parent('li').find('ul').length>0) {
			_this.append('<b class="collapse_sighn"><em class="fa fa-minus-square-o"></em></b>')
		}
	})

	$('#left-side-panel').find('li a').click(function(event) {
		_this = $(this);
		_this.parent('li').siblings('li')
			.removeClass('open')
			.children('a')
			.find('.fa-plus-square-o')
			.addClass('fa-minus-square-o')
			.removeClass('fa-plus-square-o');
		if (_this.parent('li').find('ul').length>0) {
			event.preventDefault();
			_this.parent('li')
				.toggleClass('open')
				.find('.fa-minus-square-o')
				.toggleClass('fa-plus-square-o')

		}
	})

	if ($(window).width()<1024) {
		$('body').toggleClass('menu_close');
	}

	$(window).resize(function() {
		if ($(window).width()<1024) {
			$('body').toggleClass('menu_close');
		} else {
			$('body').toggleClass('menu_close');
		}
	});

	
	if ($('#fontUpload').length) {
		$('#fontUpload').fileupload({
		    dataType: 'json',
		    url: '/admin/fonts/uploadfile',
		    sequentialUploads: true,
		    start: function(e, data) { 
		        $('.font_load_container').find('p.error').remove();   
		        $('.loaded_fonts').append('<div class="loader_pl"></div>');       
		    },
		    stop: function(e, data) {
				$('.loaded_fonts').find('.loader_pl').remove();
		    },
		    done: function(e, data) {
		    	result = data.result
		    	console.log(result)
		        if (result.success) {	        	
		        	$('.loaded_fonts').append('<div class="font_result_view"><span class="fr_name">'+result.file+'</span><a href="" class="result_font_del"><span class="glyphicon glyphicon-remove"></span></a>'+result.field+'</div>');
		        } else {
		        	$('.font_load_container').append('<p class="error">'+ result.message +'</p>');
		        }     
		    }
		});

		$(document).on('click', '.result_font_del', function(event) {
			event.preventDefault();
			$(this).closest('.font_result_view').remove();
		});
	};



	


});