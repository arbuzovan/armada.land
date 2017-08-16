<?php

$FORMS = Array();

$FORMS['login'] = <<<END
END;

$FORMS['logged'] = <<<END

			<div class="account-menu hidden-xs hidden-sm hidden-md">
				<div class="container">
					<div class="row">
						<div class="col-xs-20 left">
							<ul>
								<li%custom getProfileActiveClass('common')%><a href="/users/common/">Общая информация</a></li>
								<li%custom getProfileActiveClass('meters')%><a href="/users/meters/">Показания счетчиков</a></li>
								<li%custom getProfileActiveClass('accruals')%><a href="/users/accruals/">Начисления</a></li>
								<li%custom getProfileActiveClass('payments')%><a href="/users/payments/">История платежей</a></li>
								<li%custom getProfileActiveClass('settings')%><a href="/users/settings/">Настройки профиля</a></li>
							</ul>
						</div>
						<div class="col-xs-4 right">
							<ul>
								<li><a href="/users/logout/">Выйти</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
END;

?>