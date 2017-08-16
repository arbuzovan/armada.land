		</div>
		<!-- end content -->
			
		<!-- footer -->
                %users getStaffMenu()%
		<div id="footer">
			<div class="container">
				<div class="footer_top">
					<div class="row">
						<div class="col-xs-24 col-sm-10 left">
							<div class="address">%data getProperty('1', 'address', 'clear')%</div>
							<div class="slogan hidden-xs">%users auth('footer_requisites')%</div>
							<div class="social hidden-xs">
								<!--noindex-->
								<ul>%data getProperty('1', 'social_ok', 'social_ok')%%data getProperty('1', 'social_vk', 'social_vk')%%data getProperty('1', 'social_facebook', 'social_facebook')%%data getProperty('1', 'social_instagram', 'social_instagram')%
								</ul>
								<!--/noindex-->
							</div>
						</div>
						<div class="col-xs-24 col-sm-6 center">
							<div class="phone ya-phone">%data getProperty('1', 'phone', 'clear')%</div>
							<div class="button_block">
								<span class="button" data-target="#modal-ordercall" data-toggle="modal">Перезвоните мне</span>
							</div>
							<div class="social hidden-sm hidden-md hidden-lg">
								<!--noindex-->
								<ul>%data getProperty('1', 'social_ok', 'social_ok')%%data getProperty('1', 'social_vk', 'social_vk')%%data getProperty('1', 'social_facebook', 'social_facebook')%%data getProperty('1', 'social_instagram', 'social_instagram')%
								</ul>
								<!--/noindex-->
							</div>
						</div>
						<div class="hidden-xs col-sm-8 right">
%content menu('footer')%
						</div>
					</div>
				</div>
				<div class="footer_bottom">
					<div class="row">
						<div class="col-xs-24 col-sm-12">
							<div class="copyright">%data getProperty('1', 'copyright', 'clear')%</div>
						</div>
						<div class="col-xs-24 col-sm-12 hidden-xs">
							<div class="created">Разработка сайта &mdash; <a target="_blank" href="http://likelime.com">Likelime</a></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end footer -->
	
	</div>
	
	<!-- modal -->
	<div class="modal fade" id="modal-ordercall" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
      	<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Обратный звонок</h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="form-answer">Ваша заявка отправлена!<br />В самое ближайшее время мы Вам обязательно перезвоним</div>
						<form action="/ajax.php" method="post" id="frm-ordercall" class="ajax-popup">
							<div class="row">
								<div class="col-xs-24">
									<input type="text" name="data[trap]" class="trap" />
									<input type="text" name="data[name]" class="required" data-filter="text" placeholder="Ваше имя *" />
								</div>
							</div>
							<div class="row">
								<div class="col-xs-24">
									<input type="text" name="data[phone]" class="required input-phone" data-filter="text" placeholder="Контактный телефон *" />
								</div>
							</div>
							<div class="row">
								<div class="col-xs-24">
									<input type="text" name="data[time]" class="input-time" placeholder="Удобное время для звонка" />
								</div>
							</div>
							<div class="row">
								<div class="col-xs-24">
									<input type="hidden" name="formid" value="ordercall" />
									<input type="submit" class="btn" name="btn_send_ordercall" value="Заказать звонок" onclick="yaCounter43099904.reachGoal('call-back'); return true;" />
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal-orderplace" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
      	<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Бронирование участка</h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="form-answer">Ваша заявка отправлена!<br />В самое ближайшее время мы Вам обязательно перезвоним</div>
						<form action="/ajax.php" method="post" id="frm_orderplace" class="ajax-popup">
							<div class="row">
								<div class="col-xs-24 col-sm-8">
									<input type="text" name="data[trap]" class="trap" />
									<input type="text" name="data[name]" class="required" data-filter="text" placeholder="Ваше имя *" maxlength="20" />
								</div>
								<div class="col-xs-24 col-sm-8">
									<input type="text" name="data[phone]" class="required inp_phone" data-filter="text" placeholder="Ваш телефон *" />
								</div>
								<div class="col-xs-24 col-sm-8">
									<input type="text" name="data[email]" placeholder="E-Mail" maxlength="20" />
								</div>
							</div>
							<div class="row">
								<div class="col-xs-24">
									<textarea name="data[comment]" placeholder="Комментарии к бронированию" maxlength="300"></textarea>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-24">
									<input type="hidden" name="formid" value="orderplace" />
									<input type="hidden" name="data[place_name]" value="Графская Славянка" />
									<input type="hidden" name="data[place_number]" id="inp_place_number" value="" />
									<input type="submit" class="button" value="Забронировать" onclick="yaCounter43099904.reachGoal('bron'); return true;" />
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<a href="#modal-form-answer" id="open-modal-form-answer" data-toggle="modal" class="hidden"></a>
	<div class="modal fade" id="modal-form-answer" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
      	<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Заявка отправлена!</h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="form-answer">Ваша заявка отправлена!<br />В самое ближайшее время мы Вам обязательно перезвоним</div>
					</div>
				</div>
			</div>
		</div>
	</div>%users auth()%
	<!-- end modal -->
		
	<script type="text/javascript" src="/js/jquery.js"></script>
	<script type="text/javascript" src="/js/bootstrap.js"></script>
	<script type="text/javascript" src="/js/modernizr.js"></script>
	<script type="text/javascript" src="/js/jquery.maskedinput.js"></script>
	<script type="text/javascript" src="/js/jquery.form.js"></script>
	<script type="text/javascript" src="/js/bxslider/jquery.bxslider.js"></script>
	<script type="text/javascript" src="/js/fancybox/jquery.fancybox.js"></script>
	<script type="text/javascript" src="/js/owlcarousel/owl.carousel.min.js"></script>
	<script type="text/javascript" src="/js/isotope.min.js"></script>
	<script type="text/javascript" src="/js/header.js"></script>
	<script type="text/javascript" src="/js/account.js"></script>
	
%data getProperty('1', 'counter_other', 'clear')%

</body>

</html>