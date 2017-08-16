<?php

$FORMS = Array();

$FORMS['forget_block'] = <<<END
							<form action="%pre_lang%/users/restorep/" method="post" class="ajax-enter" id="form-forget">
								<div class="container-fluid">
									<div class="row">
										<div class="col-xs-24">
											<input type="text" name="forget_login" class="required" placeholder="Логин или e-mail адрес" />
										</div>
									</div>
									<div class="row">
										<div class="col-xs-24 col-sm-offset-5 col-sm-14">
											<input type="hidden" name="from_page" value="%from_page%" />
											<input type="submit" value="Восстановить"/>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-24">
											<ul>
												<li><span data-block-name="login">Вход в кабинет</span></li>
											</ul>
										</div>
									</div>
								</div>
							</form>
END;

$FORMS['wrong_login_block'] = <<<END
<p><b>Пользователя "%forget_login%" не существует! <a href="%pre_lang%/users/registrate">Зарегистрировать?</a></b></p>
%users forget()%
END;

$FORMS['forget_sended'] = <<<END
<p>На e-mail адрес, указанный Вами при регистрации, был выслан пароль.</p>
END;

$FORMS['mail_verification'] = <<<END
<p>Здравствуйте!<br />Кто-то, возможно Вы, пытается восстановить пароль для пользователя "%login%" на сайте <a href="http://%domain%">Armada.Land</a>.</p>
<p>Если это не Вы, просто проигнорируйте данное письмо.</p>
<p>Если Вы действительно хотите восстановить пароль, кликните по этой ссылке:<br /><a href="%restore_link%">%restore_link%</a></p>
<p>С уважением,<br />Администрация ООО «АРМАДА»</p>
END;

$FORMS['mail_verification_subject'] = "Восстановление пароля";

$FORMS['restore_failed_block'] = <<<END
<p>Невозможно восстановить пароль: неверный код активации.</p>
END;

$FORMS['restore_ok_block'] = <<<END
<p>Пароль успешно изменен, на e-mail адрес, указанный при регистрации выслано уведомление.</p>
<p>
	Логин: %login%<br />
	Пароль: %password%
</p>
END;

$FORMS['mail_password'] = <<<END
	<p>
		Здравствуйте!<br />
		Ваш новый пароль от сайта <a href="http://%domain%">Armada.Land</a>.
	</p>
	<p>
		Логин: %login%<br />
		Пароль: %password%
	</p>
	<p>
		С уважением,<br />
		Администрация ООО «АРМАДА»
	</p>
END;

$FORMS['mail_password_subject'] = "Новый пароль для сайта";

?>