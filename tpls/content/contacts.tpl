%system getOuterContent('./tpls/content/header.inc.tpl')%

			<div class="container page-inner-text contacts-page">
				<div class="row">
					<div class="col-xs-24 col-sm-12 left">
%core navibar('default', '0')%
						<div class="text-block">
							<h1>%header%</h1>
%content%
							<div class="form-block">
								<h2>Закажите звонок</h2>
								<p>Сотрудник отдела продаж предложит самые выгодные условия</p>
								<form action="/ajax.php" method="post" id="frm-ordercall-content" class="ajax">
									<div class="container-fluid">
										<div class="row">
											<div class="col-xs-24 col-sm-24 col=md-12">
												<input type="text" name="data[name]" class="required inp-name" placeholder="Ваше имя *" maxlength="20" />
											</div>
											<div class="col-xs-24 col-sm-24 col=md-12">
												<input type="text" name="data[phone]" class="required inp-phone" placeholder="Ваш телефон *" />
											</div>
											<div class="col-xs-24 col-sm-24 col=md-12">
												<input type="hidden" name="data[time]" />
												<input type="hidden" name="formid" value="ordercall" />
												<input type="submit" class="button-square" name="btn-ordercall" value="Получить консультацию" onclick="yaCounter43099904.reachGoal('consult'); return true;"/>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-xs-24 col-sm-11 col-sm-offset-1 right">
						<script type="text/javascript" src="http://api-maps.yandex.ru/2.0/?load=package.full&amp;lang=ru-RU"></script>
						<script type="text/javascript">
							var mapPointImage = '/images/template/map_point.png';
							ymaps.ready(function () {
								var myMap = new ymaps.Map('map', {
										center: [59.939095, 30.315868],
										zoom: 9,
										controls: ['smallMapDefaultSet']
										
									}, {
										searchControlProvider: 'yandex#search'
									}),
									myPlacemark_1 = new ymaps.Placemark([59.980682, 30.322480], {
										hintContent: '<div class=\'balloonHint\'>Головной офис</div>'
									}, {
										iconLayout: 'default#image',
										iconImageHref: mapPointImage,
										iconImageSize: [43, 62],
										iconImageOffset: [-21, -62]
									});
									myMap.geoObjects.add(myPlacemark_1);		
									myPlacemark_2 = new ymaps.Placemark([59.644251, 30.344577], {
										hintContent: '<div class=\'balloonHint\'>Офис продаж</div>'
									}, {
										iconLayout: 'default#image',
										iconImageHref: mapPointImage,
										iconImageSize: [43, 62],
										iconImageOffset: [-21, -62]
									});
									myMap.geoObjects.add(myPlacemark_2);	
								myMap.controls.add('zoomControl');
							});
						</script>
						<div id="map"></div>
					</div>
					</div>
				</div>
			</div>

%system getOuterContent('./tpls/content/footer.inc.tpl')%