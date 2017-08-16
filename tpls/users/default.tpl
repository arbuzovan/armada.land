<?php

$FORMS = Array();

$FORMS['login'] = <<<END

	<div class="modal fade" id="modal-account" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
      		<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Личный кабинет</h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="form-answer"></div>
						<div class="form-block-account account-login" data-modal-caption="Личный кабинет">
							<form action="%pre_lang%/users/enter/" method="post" class="ajax-enter" id="form-login">
								<div class="container-fluid">
									<div class="row">
										<div class="col-xs-24">
											<input type="text" name="login" class="required" placeholder="Логин или e-mail адрес" />
										</div>
										<div class="col-xs-24">
											<input type="password" name="password" class="required" placeholder="Пароль" />
										</div>
									</div>
									<div class="row">
										<div class="col-xs-24 col-sm-offset-4 col-sm-16">
											<input type="hidden" name="from_page" value="%from_page%" />
											<input type="submit" value="Войти"/>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-24">
											<ul>
												<li><span data-block-name="register">Зарегистрироваться</span></li>
												<li class="hidden-xs">|</li>
												<li><span data-block-name="forget">Забыли пароль?</span></li>
											</ul>
										</div>
									</div>
								</div>
							</form>
						</div>
						<div class="form-block-account account-register" data-modal-caption="Регистрация жильца">
%users registrate()%
						</div>
						<div class="form-block-account account-forget" data-modal-caption="Восстановление пароля">
%users forget()%
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
END;

$FORMS['logged'] = <<<END
END;

?>