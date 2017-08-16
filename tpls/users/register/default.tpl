<?php

$FORMS = Array();

$FORMS['registrate_block'] = <<<REGISTRATE
							<form action="%pre_lang%/users/registration/" method="post" class="ajax-enter" id="form-register">
								<div class="container-fluid">
									<div class="row">
										<div class="col-xs-24 col-sm-12">
											<input type="text" name="login" class="required" placeholder="Логин" />
										</div>
										<div class="col-xs-24 col-sm-12">
											<input type="text" name="email" class="required" placeholder="E-mail адрес" />
										</div>
									</div>
									<div class="row">
										<div class="col-xs-24 col-sm-12">
											<input type="password" name="password" class="required" placeholder="Пароль" />
										</div>
										<div class="col-xs-24 col-sm-12">
											<input type="password" name="password_confirm" class="required" placeholder="Подтверждение пароля" />
										</div>
									</div>
									<div class="row">
										<div class="col-xs-24">
											<input type="text" name="full_name" class="required" placeholder="Фамилия Имя Отчество" />
										</div>
									</div>
									<div class="row">
										<div class="col-xs-24 col-sm-12">
											<input type="text" name="phone" class="required phone" placeholder="Телефон" />
										</div>
										<div class="col-xs-24 col-sm-12">
											<input type="text" name="area_number" class="required" placeholder="Номер участка" />
										</div>
									</div>
									<div class="row">
										<div class="col-xs-24 col-sm-offset-5 col-sm-14">
											<input type="hidden" name="template" value="default" />
											<input type="submit" value="Зарегистрироваться"/>
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
REGISTRATE;

$FORMS['settings_block'] = <<<REGISTRATE
							<div class="row users-settings">
								<div class="col-xs-24 col-sm-11">
									<form action="%pre_lang%/users/saving/" method="post" class="ajax-account" id="form-settings-password">
										<div class="container-fluid">
											<div class="row">
												<div class="col-xs-24">
													<h2>Сменить пароль</h2>
												</div>
											</div>
											<div class="row">
												<div class="col-xs-24 col-sm-24 col-md-offset-9 col-md-15">
													<div class="form-answer"></div>
												</div>
											</div>
											<div class="row">
												<div class="hidden-xs col-sm-24 col-md-9">
													<label>Текущий пароль:</label>
												</div>
												<div class="col-xs-24 col-sm-24 col-md-15">
													<input type="password" name="current_password" class="required" placeholder="Текущий пароль" />
												</div>
											</div>
											<div class="row">
												<div class="hidden-xs col-sm-24 col-md-9">
													<label>Новый пароль:</label>
												</div>
												<div class="col-xs-24 col-sm-24 col-md-15">
													<input type="password" name="password" class="required" placeholder="Новый пароль" />
												</div>
											</div>
											<div class="row">
												<div class="hidden-xs col-sm-24 col-md-9">
													<label>Подтверждение:</label>
												</div>
												<div class="col-xs-24 col-sm-24 col-md-15">
													<input type="password" name="password_confirm" class="required" placeholder="Подтверждение пароля" />
												</div>
											</div>
											<div class="row">
												<div class="col-xs-24 col-sm-offset-9 col-sm-15">
													<input type="hidden" name="method" value="edit_password" />
													<input type="submit" class="button-square" value="Изменить пароль"/>
												</div>
											</div>
										</div>
									</form>
								</div>
								<div class="col-xs-24 col-sm-offset-2 col-sm-11">
									<form action="%pre_lang%/users/saving/" method="post" class="ajax-account" id="form-settings-email">
										<div class="container-fluid">
											<div class="row">
												<div class="col-xs-24">
													<h2>Сменить e-mail</h2>
												</div>
											</div>
											<div class="row">
												<div class="col-xs-24 col-sm-24 col-md-offset-9 col-md-15">
													<div class="form-answer"></div>
												</div>
											</div>
											<div class="row">
												<div class="hidden-xs col-sm-24 col-md-9">
													<label>Текущий пароль:</label>
												</div>
												<div class="col-xs-24 col-sm-24 col-md-15">
													<input type="password" name="current_password" class="required" placeholder="Текущий пароль" />
												</div>
											</div>
											<div class="row">
												<div class="hidden-xs col-sm-24 col-md-9">
													<label>Новый e-mail:</label>
												</div>
												<div class="col-xs-24 col-sm-24 col-md-15">
													<input type="text" name="email" class="required" placeholder="Новый e-mail" />
												</div>
											</div>
											<div class="row">
												<div class="hidden-xs col-sm-24 col-md-9">
													<label>Подтверждение:</label>
												</div>
												<div class="col-xs-24 col-sm-24 col-md-15">
													<input type="text" name="email_confirm" class="required" placeholder="Подтверждение e-mail" />
												</div>
											</div>
											<div class="row">
												<div class="col-xs-24 col-sm-offset-9 col-sm-15">
													<input type="hidden" name="method" value="edit_email" />
													<input type="submit" class="button-square" value="Изменить e-mail"/>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
REGISTRATE;

$FORMS['registrate_done_block'] = <<<END
Регистрация прошла успешно. На ваш e-mail отправлены данные для входа в личный кабинет. Ваш аккаунт будет активирован после проверки нашими менеджером.
END;

$FORMS['registrate_done_block_without_activation'] = <<<END
Регистрация прошла успешно.
END;

$FORMS['registrate_done_block_error'] = <<<END
Регистрация завершилась неудачей. Проверьте правильность заполнения всех полей.
END;

$FORMS['registrate_done_block_user_exists'] = <<<END
Пользователь с таким именем уже существует. Попробуйте выбрать другое.
END;

$FORMS['activate_block'] = <<<END
<p>Аккаунт активирован.</p>
END;

$FORMS['mail_registrated_subject'] = "Регистрация на Armada.Land";

$FORMS['activate_block_failed'] = <<<END
	<p>Неверный код активации.</p>
END;

$FORMS['mail_registrated'] = <<<MAIL
	<p>Здравствуйте, %lname% %fname% %father_name%, <br />Вы зарегистрировались на сайте <a href="http://%domain%">Armada.Land</a>.</p>
	<p>Логин: %login%<br />Пароль: %password%</p>
	<p>Ваш аккаунт будет активирован после проверки нашим менеджером.</p>
MAIL;

$FORMS['mail_admin_registrated'] = <<<END
<p>Зарегистрировался новый пользователь "%login%" на сайте. Для активации учетной записи перейдите на страницу в <a href="http://armada.land/admin/users/edit/%user_id%/">панеле управления</a> сайтом</p>
END;

$FORMS['mail_admin_registrated_subject'] = "Регистрация жильца";

?>