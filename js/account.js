function parseGETParameters() {
	var result = {};
	var gets = window.location.search.replace(/&amp;/g, '&').substring(1).split('&');
	for (var i = 0; i < gets.length; i++) {
		var get = gets[i].split('=');
		result[get[0]] = typeof(get[1]) == 'undefined' ? '' : get[1];
	}
	return result;
}


function showModalAnswerSuccess(form, answer, message) {
	answer.removeClass('error-form-answer');
	answer.html(message);
	form.parent().slideUp(200);
	form.trigger('reset');
}

/* -------- Document ready -------- */

$(document).ready(function(){

	$('#modal-account .form-block-account ul li span').click(function(){
		var _block = $('.account-' + $(this).data('block-name'));
		if ($(this).data('block-name') == 'register') {
			$('#modal-account .modal-dialog').addClass('modal-lg');
		} else {
			$('#modal-account .modal-dialog').removeClass('modal-lg');
		}
		$('#modal-account').find('.form-answer').slideUp(300)
		$('#modal-account h4').html(_block.data('modal-caption'));
		$('#modal-account .form-block-account').slideUp(300);
		$('#modal-account form').trigger('reset');
		$('#modal-account form *').removeClass(errorClass);
		_block.slideDown(300);
	});

	$('.open-modal-account').click(function() {
		$('#modal-account .modal-dialog').removeClass('modal-lg');
		$('#modal-account h4').html($('#modal-account .account-login').data('modal-caption'));
		$('#modal-account .form-block-account').css('display', 'none');
		$('#modal-account form').trigger('reset');
		$('#modal-account form *').removeClass(errorClass);
		$('#modal-account .account-login').css('display', 'block');
	});

	$('#open-modal-gotopay').click(function(){
		var modal = $('#modal-gotopay');
		modal.find('.request-answer').remove();
		modal.find('udata').remove();
		modal.find('.ajax-gotopay').trigger('reset').show();
	});

	$('.ajax-enter').submit(function(){
		var form = $(this),
			answer = form.parent().parent().find('.form-answer');
		if (check_form(form)) {
			form.ajaxSubmit({
				url: '/udata:/' + form.attr('action') + '.json',
				type: 'POST',
				dataType: 'json',
				beforeSubmit: function(){
					form.find('input[type=submit]').prop('disabled', true);
					form.find('input[type=submit]').addClass('load');
				},
				success: function(data){
					console.log(data);
					if (!data.success) {
						answer.addClass('error-form-answer');
						answer.html(data.message);
					} else {
						if (typeof data.redirect !== 'undefined') {
							window.location.href = data.redirect_url;
						} else {
							showModalAnswerSuccess(form, answer, data.message);
						}
					}
					answer.slideDown(300);
					form.find('input[type=submit]').prop('disabled', false);
					form.find('input[type=submit]').removeClass('load');
				}
			});
		}
		return false;
	});

	var pGET = parseGETParameters();
	if (typeof pGET.activate_code !== 'undefined') {
		$.ajax({
			url: '/udata:/users/restore/' + pGET.activate_code + '/.json',
			type: 'GET',
			dataType: 'json',
			success: function(data){
				$('#modal-form-answer').find('.modal-title').html('Восстановление пароля');
				if (data.status == 'success') {
					$('#modal-form-answer').find('.form-answer').html('Пароль успешно изменен! На e-mail адрес, указанный при регистрации выслан новый пароль.');
				} else {
					$('#modal-form-answer').find('.form-answer').html('Пароль не изменен! Код активации неверен или уже использован');
				}
				$('#modal-form-answer').find('.form-answer').show();
				$('#open-modal-form-answer').trigger('click');
			}
		});
	}

	$('.ajax-account').submit(function(){
		var form = $(this),
			answer = form.find('.form-answer');
		if (check_form(form)) {
			form.ajaxSubmit({
				url: '/udata:/' + form.attr('action') + '.json',
				type: 'POST',
				dataType: 'json',
				beforeSubmit: function(){
					form.find('input[type=submit]').prop('disabled', true);
					form.find('input[type=submit]').addClass('load');
				},
				success: function(data){
					console.log(data);
					if (!data.success) {
						answer.addClass('error-form-answer');
						answer.html(data.message);
					} else {
						answer.slideUp();
						if (typeof data.redirect !== 'undefined') {
							window.location.href = data.redirectURL;
						} else {
							$('#modal-form-answer').find('.modal-title').html('Изменение настроек');
							$('#modal-form-answer').find('.form-answer').html(data.message);
							$('#modal-form-answer').find('.form-answer').show();
							$('#open-modal-form-answer').trigger('click');
						}
						form.trigger('reset');
					}
					form.find('input[type=submit]').prop('disabled', false);
					form.find('input[type=submit]').removeClass('load');
				}
			});
		}
		return false;
	});

	$('.ajax-gotopay').submit(function(){
		var form = $(this),
			inputAmount = form.find('[name="amount"]'),
			amount = inputAmount.val();

		inputAmount.val(amount.replace(/[^0-9]/gim,''));

		if (check_form(form)) {
			form.ajaxSubmit({
				url: '/udata:/' + form.attr('action'),
				type: 'POST',
				dataType: 'html',
				beforeSubmit: function(){
					form.find('input[type=submit]').prop('disabled', true);
					form.find('input[type=submit]').addClass('load');
				},
				success: function(data){
					form.hide();
					form.parent().append(data);
					form.find('input[type=submit]').prop('disabled', false);
					form.find('input[type=submit]').removeClass('load');
				}
			});
		}
		return false;
	});
	
});