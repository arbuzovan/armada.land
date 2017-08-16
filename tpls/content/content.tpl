%system getOuterContent('./tpls/content/header.inc.tpl')%

			<div class="container page-inner-text">
				<div class="row">
					<div class="col-xs-24">
%core navibar('default', '0')%		
					</div>
				</div>
				<div class="row">	
					<div class="col-xs-24">
						<div class="text-block">
<h1>%header%</h1>
%content%
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

%system getOuterContent('./tpls/content/footer.inc.tpl')%