
var errorClass = 'error-input';


/* -------- Check form input -------- */

function check_form(form) {
	var successCheck = true;	
	form.find('.required').each(function(){
		if ($.trim($(this).val()) == '') {
			$(this).addClass(errorClass);
			successCheck = false;
		} else {
			$(this).removeClass(errorClass);
		}
	});
	return successCheck;
}


/* -------- Redraw block after resize -------- */

function redraw() {
	if ($(window).width() > 768) {
		$('#content .contacts-page .right #map').css('height', $('#content .contacts-page .left').height() + 'px');
		$('#content .object-view .description .right .object-map-spoiler').css('height', $('#content .object-view .description .left').height() + 'px');
	} else {
		$('#content .object-view .description .right .object-map-spoiler').css('height', '300px');
	}
	if ($(window).width() > 600) {
		$('#header .top-line .right .phone').removeAttr('data-toggle');
	} else {
		$('#header .top-line .right .phone').attr('data-toggle', 'modal');
	}

	$('#content .object-view .description .right .object-map-spoiler').css('width', $('#content .object-view .description .right').width() + 'px');
}

/**
 * Функция переключает состояние кнопки
 * @param {type} btnObj Объект кнопки
 */
function toggleEditBtn(btnObj) {
    if($(btnObj).hasClass('editButton')){
        $(btnObj).removeClass('editButton');
        $(btnObj).addClass('saveButton');
        $(btnObj).html('Сохранить');   
    }else{
        $(btnObj).removeClass('saveButton');
        $(btnObj).addClass('editButton');
        $(btnObj).html('Редактировать');
    }
}

/**
 * Функция переключает состояние кнопки
 * @param {type} btnObj Объект кнопки
 */
function toggleAddMeterBtn(btnObj) {
    if($(btnObj).hasClass('addMetersBtn')){
        $(btnObj).removeClass('addMetersBtn');
        $(btnObj).addClass('saveMeterButton');
        $(btnObj).html('Сохранить показания');   
    }else{
        $(btnObj).removeClass('saveMeterButton');
        $(btnObj).addClass('addMetersBtn');
        $(btnObj).html('Добавить показания');
    }
}




/* -------- Document ready -------- */

$(document).ready(function(){

	redraw();

	$('input[name=phone], input[name="data[phone]"], input[name="data[new][phone]"], .inp-phone').mask('+7 (999) 999-99-99');
	$('input[name="data[time]"], .inp-time').mask('99:90');
	$('.fancybox').fancybox({ 
		padding	: 2,
		openEffect: 'elastic',
		closeEffect: 'elastic',
		prevEffect: 'fade',
		nextEffect: 'fade'
	});
	
	$('#content .object-view .groups-parameters .groups-parameters-item h3').click(function(){
		if ($(this).parent().hasClass('open')) {
			$(this).parent().removeClass('open');
			$(this).parent().find('.groups-parameters-spoiler').slideUp();
		} else {
			$(this).parent().addClass('open');
			$(this).parent().find('.groups-parameters-spoiler').slideDown();
		}
	});

	$('.houses-filter .button').click(function(){
		var selector = $(this).data('filter');
		$('.houses-filter .button').removeClass('active');
		$(this).addClass('active');
		$('.houses-listing').isotope({
			filter: selector,
			animationOptions: {
				duration: 2000,
				easing: 'easeOutQuart',
				queue: false
			}
		});
	});

	$('#header .top-line .right #slide-menu-button').click(function(){
		if ($('#header .top-line .left .menu').hasClass('show')) {
			$('#header .top-line .left .menu').css('right', '-' + $('#header .top-line .left .menu').width() + 'px');
			$('#header .top-line .left .menu').removeClass('show');
		} else {
			$('#header .top-line .left .menu').css('right', '0px');
			$('#header .top-line .left .menu').addClass('show');
		}
	});

	$('#header .top-line .left .menu .menu-slide-direction .menu-slide-close').click(function(){
		$('#header .top-line .left .menu').css('right', '-'+$('#header .top-line .left .menu').width()+'px');
		$('#header .top-line .left .menu').removeClass('show');
	});

	$(document).on('click', '.object-view .balloonContent .description .btn-button .button-green', function(){
		$('#frm_orderplace #inp_place_number').val($(this).data('area-id'));
	});

	if ($('#index-slider li').length > 1) {
		$('#index-slider').bxSlider({
			pager: false,
			mode: 'horizontal',
			auto: true, 
			pause: 4000, 
			autoHover: true, 
			autoStart: true,
			controls: true
		});
	}

	if ($('#house-image-slider li').length > 1) {
		var sliderMode = '';
		if ($(window).width() > 768) {
			sliderMode = 'fade';
		} else {
			sliderMode = 'horizontal';
		}
		var house_slider = $('#house-image-slider').bxSlider({
			pager: false,
			mode: sliderMode,
			auto: false, 
			pause: 4000, 
			autoHover: false, 
			autoStart: false,
			controls: false
		});
	}

	$('#content .page-house-item .house-image-thumb .item-image').click(function(){
		$('#content .page-house-item .house-image-thumb .item-image').removeClass('active');
		$(this).addClass('active');
		house_slider.goToSlide($(this).data('slide-id'));
	});
	
	if ($('#owl-gallery').length) {
		$('#owl-gallery').owlCarousel({
			responsive: {
				0: {items: 1},
				450: {items: 2},
				1000: {items: 3},
				1500: {items: 4},
				1920: {items: 5}
			},
			margin: 0,
			loop: true,
			navText: ["",""],
			nav : true
		});
	}

	if ($('#owl-construction').length) {
		$('#owl-construction').owlCarousel({
			responsive: {
				0: {items: 1},
				450: {items: 2},
				1000: {items: 3},
				1500: {items: 4},
				1920: {items: 5}
			},
			margin: 0,
			loop: true,
			navText: ["",""],
			nav : true
		});
	}

	$('.videos .video-item a').click(function(){
		var modal = $('#modal-video'),
			link = $(this);
		modal.find('.modal-title').html(link.data('title'));
		modal.find('iframe').attr('src', link.data('src'));
	});
	
	$('.scrollTo').click(function(){
		if ($(this).attr('href')) {
			var DOM = $(this).attr('href');
		} else {
			if ($(this).attr('data-scroll-to')) {
				var DOM = $(this).attr('data-scroll-to');
			} else {
				return false;
			}
		}
		if ($(DOM).length) {
			$('html, body').animate({scrollTop:$(DOM).offset().top}, 'slow');
		}	
		return false;
	});
	
	$('.ajax-popup').submit(function(){
		var form = $(this);
		if (check_form(form)) {
			form.ajaxSubmit({
				beforeSubmit: function(){
					form.find('input[type=submit]').attr('disabled','disabled');
					form.find('input[type=submit]').addClass('load');
				},
				success: function(data){
					form.trigger('reset');
					form.parent().find('.form-answer').slideDown(200);
					form.slideUp(200);
				}
			});
		}
		return false;
	});

	$('.ajax').submit(function(){
		var form = $(this);
		if (check_form(form)) {
			form.ajaxSubmit({
				beforeSubmit: function(){
					form.find('input[type=submit]').attr('disabled','disabled');
					form.find('input[type=submit]').addClass('load');
				},
				success: function(data){
					form.trigger('reset');
					$('#open-modal-form-answer').trigger('click');
					form.find('input[type=submit]').prop('disabled', false);
					form.find('input[type=submit]').removeClass('load');
				}
			});
		}
		return false;
	});

	$('[data-target="#modal-genplan"]').click(function(){
		if (typeof ymaps != "undefined")ymaps.ready(Map.init);
	});
        
        $(document).on('click','.tarifEditBtn', function(){
            var objId = $(this).attr('rel');
            var btnObj = $(this);
            var paramArray = {};
            
            if($(this).hasClass('editButton')){    
                paramArray.id = objId;
                var action = 'GET';
            }else{
                var action = 'POST';
                paramArray.id = objId;
                paramArray.newValue = $('input[rel='+objId+']').val();
            }
            
            $.ajax({
                url:'/data/crudTarif/',
                method:action,
                data:paramArray,
                dataType: 'json',
                error: function(){
                    alert('В процессе соединения с сервером произошла ошибка.');
                },
                success: function(answer){
                    switch(answer.status){
                        case 'error':
                            alert(answer.message);
                            break;
                        default:
                            switch(answer.action){
                                case 'GET':
                                    $('td.tarifCol[rel='+objId+']').html('<input type="text" value="'+answer.value+'" rel="'+objId+'" />');
                                    toggleEditBtn(btnObj);
                                    break;
                                case 'UPDATE_DATA':
                                    $('td.tarifCol[rel='+objId+']').html(answer.value);
                                    toggleEditBtn(btnObj);
                                    break;
                                default:
                                    toggleEditBtn(btnObj);
                                    break;
                            }
                            break;
                    }
                },
                complete: function() {
                  console.log('request_complete');
                }
            });
            return false;
        });
        
        $(document).on('click','.addMetersBtn',function(){
            toggleAddMeterBtn(this);
            /* Формирование select'a с выбором месяца */
            var month = ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'];   // Массив месяцов
            var curMonthIndex = new Date().getMonth();
            
            var MonthSelect = $('<select class="month"><option val="0"></option></select>');
            $(month).each(function(index, element){
               var selected = '';
               if(index == curMonthIndex){
                   selected = 'selected';
               }
               monthNum = index++;
               var option = $('<option value="'+monthNum+'" '+selected+'>'+element+'</option>');
               $(option).appendTo(MonthSelect);
            });
            /* Формирование select'a с выбором месяца */
            
            /* Формирование списка участков */
            var areaSelect = $('<select class="areaNum"></select>');
            $.ajax({
                url:'/data/getAreaNumbers/',
                dataType: 'json',
                //async: false,
                success: function(answer){
                    for(area_num in answer){
                        var option = $('<option value="'+area_num+'">'+area_num+'</option>');
                        $(option).appendTo(areaSelect);                        
                    }
                }
            });
            /* Формирование списка участков */
            
            /* Обработка ввода показаний счетчиков */
            $(document).on('change','.curMeterVal, .areaNum',function(){
                var area_num = $('.areaNum').val();
                var currentMeter = $('.curMeterVal').val();

                $.ajax({
                    url:'/data/getPrevMetersAjax/',
                    data:{
                        'area_number':area_num,
                        'currentMeter':currentMeter
                    },
                    dataType: 'json',
                    success: function(answer){
                        return false;
                    }
                });
            });
            /* Обработка ввода показаний счетчиков */
            
            /* Формирование поля ввода для текущих показаний*/
            var inputMeter = $('<input class="curMeterVal" type="text" />');
            /* Формирование поля ввода для текущих показаний*/
            
            var lastNum = $('tr.line').last().find('td').first().text() - 0;    // Берем последний индекс из таблицы
            var addMeterRow = $('tr.line').last().clone();                      // Клонируем последниюю строку из таблицы
//            var tarif = false;
//            
//            $.ajax({
//                url:'/data/getTarif/',
//                dataType: 'json',
//                data:{
//                    'tarifName':'elenergiya_den',
//                    'json':true
//                },
//                success: function(answer){
//                    tarif = answer;
//                    $(addMeterRow).find('td').eq(3).html(inputMeter);
//                }
//            });

            $(addMeterRow).find('td').html('');                                 // Очищаем все ячейки
            $(addMeterRow).find('td').first().html(lastNum+1);                  // Добавляем индекс
            $(addMeterRow).find('td').eq(1).html(areaSelect);                   // Добавляем выбор участка
            $(addMeterRow).find('td').eq(2).html(MonthSelect);                  // Добавляем выбор месяца
            $(addMeterRow).find('td').eq(3).html(inputMeter);                   // Добавляем поле ввода текущих показаний
            
            $(addMeterRow).appendTo('.table');                                  // Созданную строку добавляем к таблице
            return false;   
        });
        
        $(document).on('click','.saveMeterButton',function(){
            var area_num = $('.areaNum').val();
            var currentMeter = $('.curMeterVal').val();
            
            if(!area_num || area_num == 0){
                return false;
            }
            
            if(!currentMeter || currentMeter == 0 || currentMeter == ''){
                return false;
            }
            
            $.ajax({
                url:'/data/crudMeters/',
                data:{
                    'area_number':area_num,
                    'currentMeter':currentMeter
                },
                method: 'POST',
                dataType: 'json',
                success: function(answer){
                    if(answer.status == 'ok'){
                        document.location.reload();
                    }
                }
            });
            
            toggleAddMeterBtn(this);
            return false;
        });
	
});


/*
 $(document).on('click', '.button_buy', function() {
  var rel = $(this).attr('rel');
  toggleBuyBtn(this);
  $.ajax({
    url: 'somePath',
    method: 'POST',
    data: {
      id: $(rel)
    },
    dataType: 'json',
    success: function() {
      console.log('request_success');
    },
    error: function() {
      console.log('request_error');
    },
    complete: function() {
      console.log('request_complete');
    }
  })
});
 */

/* -------- Window resize -------- */

$(window).resize(function(){
	redraw();
});