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
				<div class="documents">
					%custom getPages('default', '646', '1', '0', '7', '128')%
				</div>
			</div>

%system getOuterContent('./tpls/content/footer.inc.tpl')%