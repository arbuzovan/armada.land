%system getOuterContent('./tpls/content/header.inc.tpl')%

			<div class="slider">
%custom getCatalogList('0', 'index_slider')%
				<span class="arrow-down scrollTo" data-scroll-to="#anchor-index-map"></span>
			</div>

			<div class="index-map" id="anchor-index-map">
				<script type="text/javascript" src="http://api-maps.yandex.ru/2.0/?load=package.full&amp;lang=ru-RU"></script>
				<script type="text/javascript">
					var mapPointImage = 'images/template/point_slavyanka.png';
					ymaps.ready(function () {
						var myMap = new ymaps.Map('map', {
							center: [59.644251, 30.344577],
							zoom: 9,
							type: 'yandex#map',
							controls: []
						});
%custom getCatalogList('0', 'index_map_points')%	
						myMap.controls.add('zoomControl');
					});
				</script>
				<div id="map"></div>
			</div>
			
			<div class="about-and-news">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xs-24 col-sm-offset-2 col-sm-18 col-md-offset-2 col-md-10">
							<div class="text-block">
%content%
							</div>
						</div>
						<div class="col-xs-24 col-md-offset-1 col-md-9">
							<div class="news container-fluid">
								<h2>Новости</h2>
								<div class="row">
									<div class="news-listing">
%news lastlist('5', 'last_news', '2', '1')%
									</div>
								</div>
								<div class="row">
									<div class="col-xs-24">
										<a href="%content get_page_url('5')%" class="link-more">Все новости</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

%system getOuterContent('./tpls/content/footer.inc.tpl')%