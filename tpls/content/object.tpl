%system getOuterContent('./tpls/content/header.inc.tpl')%

			<div class="object-view">
				<div class="banner" style="background-image: url(%data getProperty(%id%, 'banner', 'clear')%);">
					<div class="container">
						<div class="object-header">
							<div class="object-header-caption">
								<div class="category">%data getProperty(%id%, 'category', 'clear')%</div>
								<h1>%header%</h1>
							</div>%data getProperty(%id%, 'add_discount_block', 'add_discount_block')%
						</div>
					</div>
				</div>
				<div class="description">
					<div class="container">
						<div class="row">
							<div class="col-xs-24 col-sm-11 col-md-11 left">
								<div class="text-block">
%content%
								</div>
							</div>
							<div class="col-xs-24 col-sm-13 col-md-13 right">
								<div class="object-map-spoiler">
									<button class="button button-blue" data-target="#modal-genplan" data-toggle="modal">Открыть генплан</button>
									<button class="button button-blue" data-target="#modal-3dtoure" data-toggle="modal">Открыть 3D панораму</button>
								</div>
							</div>
						</div>
					</div>
				</div>%data getProperty(%id%, 'video_dlya_poselka', 'videos')%
				<div class="gallery">
%custom PropertySetOfImages(%id%, 'main_photos', 'photos_main')%
				</div>
				<div class="groups-parameters">
					<div class="container">
						<div class="row">
							<div class="col-xs-24">
								<h2>Почему стоит выбрать «Графскую Славянку»?</h2>
								<div class="groups-parameters-item open">
									<h3>Близость к северной столице</h3>
									<div class="groups-parameters-spoiler">
										<div class="text-block">
%data getProperty(%id%, 'kommunikacii', 'clear')%
										</div>
									</div>
								</div>
								<div class="groups-parameters-item">
									<h3>Уникальное расположение поселка</h3>
									<div class="groups-parameters-spoiler">
										<div class="text-block">
%data getProperty(%id%, 'infrastruktura', 'clear')%
										</div>
									</div>
								</div>
								<div class="groups-parameters-item">
									<h3>Развитая инфраструктура</h3>
									<div class="groups-parameters-spoiler">
										<div class="text-block">
%data getProperty(%id%, 'mestopolozhenie', 'clear')%
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>%custom PropertySetOfImages(%id%, 'photos_construction', 'photos_construction', '1')%
				<div class="purchase-terms">
					<div class="container">
						<div class="row">
							<div class="col-xs-24 col-sm-14 left">
								<div class="text-block">
%data getProperty(%id%, 'purchase_terms', 'clear')%
								</div>
							</div>
							<div class="col-xs-24 col-sm-offset-1 col-sm-9 right">
								<div class="form-block">
									<h2>Выбирайте с нами</h2>
									<p>Сотрудник отдела продаж предложит самые выгодные условия</p>
									<form action="/ajax.php" method="post" id="frm-ordercall-content" class="ajax">
										<input type="text" name="data[trap]" class="trap" />
										<input type="text" name="data[name]" class="required inp-name" placeholder="Ваше имя *" maxlength="20" />
										<input type="text" name="data[phone]" class="required inp-phone" placeholder="Ваш телефон *" />
										<input type="hidden" name="data[time]" />
										<input type="hidden" name="formid" value="ordercall" />
										<input type="submit" class="button-square" name="btn-ordercall" value="Получить консультацию" />
									</form>
									<div class="phone">%data getProperty('1', 'phone', 'clear')%</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="another-news">
				<div class="news container">
					<h2>Новости</h2>
					<div class="row">
						<div class="news-listing">
%news lastlist('5', 'last_news_page', '2', '1')%
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="modal-genplan" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-lg">
		      	<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						</div>
						<div class="modal-body">
							<img class="img-responsive img-genplan hidden-sm hidden-md hidden-lg" src="%data getProperty(%id%, 'genplan', 'clear')%" alt="План поселка &laquo;%header%&raquo;" />
							<script type="text/javascript" src="http://api-maps.yandex.ru/2.0/?load=package.full&amp;lang=ru-RU"></script>
							<script language="javascript" src="/js/map.js"></script>
							<script type="text/javascript">
								Map.points = {};
								Map.points["point_%id%"] = new Map.Point({
									id: %id%,
									lat: %data getProperty(%id%, 'gps_lat', 'clear')%,
									lng: %data getProperty(%id%, 'gps_lng', 'clear')%,
									zoom: 16,
									name: '%data getProperty(%id%, h1, clear)%',
									html: "<div class=\'balloonContent\'><div class=\'image\'><img src=\'%data getProperty(%id%, baloon_image, baloon_image)%\' alt=\'%data getProperty(%id%, h1, clear)%\' /></div><div class=\'description\'><div class=\'name\'>%data getProperty(%id%, h1, clear)%</div><div class=\'category\'>%data getProperty(%id%, category, clear)%</div><div class=\'place\'><span>%data getProperty(%id%, region, clear)%</span></div><div class=\'text\'>%data getProperty(%id%, baloon_characters, clear)%</div></div></div>",
									htmlOver: "<div class=\'balloonHint\'>%data getProperty(%id%, h1, clear)%</div>",
									pos: '4',
									withLayer: true,
									onDrag: null,
									pointZoom: 13,				
								});%custom getPlaceItems(%id%, %data getProperty(%id%, baloon_image, baloon_image)%)%
								Map.lat = %data getProperty(%id%, 'gps_lat', 'clear')%;
								Map.lng = %data getProperty(%id%, 'gps_lng', 'clear')%;
								Map.zoom = 16;
								Map.withGlobalLayer = false;
							</script>
							<div class="map-block hidden-xs">
								<div id="map"></div>
								<div class="map-overlay">
									<ul>
										<li><span class="circle-green"></span>Свободен</li>
										<li><span class="circle-red"></span>Продан</li>
										<li><span class="circle-gray"></span>Не в продаже</li>
										<li><span class="circle-orange"></span>Краткосрочное бронирование</li>
										<li><span class="circle-purple"></span>Долгосрочное бронирование</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="modal-3dtoure" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-lg">
		      	<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						</div>
						<div class="modal-body">
							<iframe src="/3d/grafslav.html" scrolling="no" noresize="noresize"></iframe>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="modal-video" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-lg">
		      	<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title"></h4>
						</div>
						<div class="modal-body">
							<iframe width="100%" height="400" src="" frameborder="0" allowfullscreen="allowfullscreen"></iframe>
						</div>
					</div>
				</div>
			</div>

%system getOuterContent('./tpls/content/footer.inc.tpl')%