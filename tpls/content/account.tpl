%system getOuterContent('./tpls/content/header.inc.tpl')%

			<div class="users-information-block">
				<div class="container">
					<div class="row">	
						<div class="col-xs-24 col-sm-16">
							<div class="about-user">
%users auth('account_information')%
							</div>
						</div>
						<div class="col-xs-24 col-sm-8">
							<div class="user-debts">
%users auth('account_balance')%
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="users-content-block">
				<div class="container">
					<div class="row">	
						<div class="col-xs-24">
%content%
						</div>
					</div>
				</div>
			</div>

			<!-- modal -->
			<div class="modal fade" id="modal-gotopay" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog">
		      		<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Внести платеж</h4>
						</div>
						<div class="modal-body">
							<div class="container-fluid">
								<form action="/users/gotopay/" method="post" class="ajax-gotopay">
									<div class="row">
										<div class="col-xs-24">
											<input type="text" name="amount" class="required" placeholder="Сумма платежа *" maxlength="10" />
										</div>
									</div>
									<div class="row">
										<div class="col-xs-24">
											<input type="submit" class="btn" value="Продолжить" />
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>

%system getOuterContent('./tpls/content/footer.inc.tpl')%