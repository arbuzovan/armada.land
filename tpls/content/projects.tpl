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
				<div class="row">
					<div class="col-xs-24">
						<ul class="houses-filter">
							<li>Технология:</li>
%custom getGuideList('123', 'houses_filter')%
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="houses-listing">
%content menu('projects_houses', '1', %id%)%
					</div>
				</div>
			</div>

%system getOuterContent('./tpls/content/footer.inc.tpl')%