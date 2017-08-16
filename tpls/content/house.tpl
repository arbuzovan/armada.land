%system getOuterContent('./tpls/content/header.inc.tpl')%
			
			<div class="container page-inner-text page-house-item">
				<div class="row">
					<div class="col-xs-24">
%core navibar('default', '0')%		
						<div class="text-block">
							<h1>%header%</h1>
						</div>
					</div>
				</div>
				<div class="row">	
					<div class="col-xs-24 col-sm-10">
						<div class="row">
							<div class="col-xs-24">
								<ul id="house-image-slider" class="bxslider">
									<li><a class="fancybox" href="%data getProperty(%id%, 'main_image', 'clear')%" rel="house"><img class="img-responsive" src="%data getProperty(%id%, 'main_image', 'house_view_image')%" alt="%header%" /></a></li>%custom PropertySetOfImages(%id%, 'images', 'house_images')%
								</ul>
							</div>
						</div>
						<div class="row hidden-xs house-image-thumb">
							<div class="col-xs-8">
								<div class="item-image active" data-slide-id="0">
									<img class="img-responsive" src="%data getProperty(%id%, 'main_image', 'house_images_thumb')%" alt="%header%" />
								</div>
							</div>%custom PropertySetOfImages(%id%, 'images', 'house_images_thumb')%
						</div>
					</div>
					<div class="col-xs-24 col-sm-14 right-panel">
						<div class="row">
							<div class="col-xs-24 col-sm-24 col-md-13">
								<div class="params-caption">Общие характеристики проекта</div>
%data getPropertyGroup(%id%, 'harakteristiki_doma', 'harakteristiki_doma')%
							</div>
							<div class="col-xs-24 col-sm-24 col-md-10 col-md-offset-1">
								<div class="params-caption">Технология</div>
%data getProperty(%id%, 'technology', 'house_technology')%
							</div>
						</div>%data getProperty(%id%, 'price', 'house_price')%%data getProperty(%id%, 'content', 'house_content')%
					</div>
				</div>
			</div>

%system getOuterContent('./tpls/content/footer.inc.tpl')%