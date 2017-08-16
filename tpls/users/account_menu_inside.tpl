<?php

$FORMS = Array();

$FORMS['login'] = <<<END
END;

$FORMS['logged'] = <<<END

								<div class="account-menu-inside hidden-lg">
									<div class="menu-slide-direction">Личный кабинет</div>
									<ul>
										<li><a href="/users/common/">Общая информация</a></li>
										<li><a href="/users/meters/">Показания счетчиков</a></li>
										<li><a href="/users/accruals/">Начисления</a></li>
										<li><a href="/users/payments/">История платежей</a></li>
										<li><a href="/users/settings/">Настройки профиля</a></li>
										<li><a href="/users/logout/">Выйти</a></li>
									</ul>
								</div>
END;

?>