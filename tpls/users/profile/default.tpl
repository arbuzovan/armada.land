<?php

$FORMS = Array();

$FORMS['receipts_block'] = <<<END
%items%
END;

$FORMS['receipts_item'] = <<<END
						<h2>Начисления за %date%</h2>
						<div class="table-responsive">
							<table class="table profile-table">
								<tr class="caption">
									<td width="6%">Номер</td>
									<td width="20%">Наименование услуги</td>
									<td width="12%">Тариф</td>
									<td width="12%">Норматив</td>
									<td width="12%">Полная стоимость</td>
									<td width="12%">Льгота</td>
									<td width="12%">Перерасчет</td>
									<td width="12%">Сумма</td>
								</tr>%rows%
								<tr class="total">
									<td>&nbsp;</td>
									<td>Итого:</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>%itogoStoimost%</td>
									<td>%itogoLgota%</td>
									<td>%itogoPereraschet%</td>
									<td>%itogoSumma%</td>
								</tr>
							</table>
						</div>
END;

$FORMS['receipts_item_row'] = <<<END

								<tr class="line">
									<td>%number%</td>
									<td>%title%</td>
									<td>%tarif%</td>
									<td>%normativ%</td>
									<td>%stoimost%</td>
									<td>%lgota%</td>
									<td>%pereraschet%</td>
									<td>%summa%</td>
								</tr>
END;

$FORMS['receipts_block_empty'] = <<<END
						<p>Пока нет квитанций для отображение</p>
END;

$FORMS['meters_block'] = <<<END
						<h2>Показания счетчиков</h2>
						<div class="table-responsive">
							<table class="table profile-table">
								<tr class="caption">
									<td width="15%">Номер счетчика</td>
									<td width="25%">Тип счетчика</td>
									<td width="25%">Период</td>
									<td width="25%">Текущие показания</td>
								</tr>%items%
							</table>
						</div>
END;

$FORMS['meters_item'] = <<<END

								<tr class="line">
									<td>%number%</td>
									<td>%title%</td>
									<td>%date%</td>
									<td>%value% кВт</td>
								</tr>
END;

$FORMS['meters_block_empty'] = <<<END
						<p>Пока нет показаний для отображение</p>
END;

$FORMS['payments_block'] = <<<END
						<div class="table-responsive">
							<table class="table profile-table">
								<tr class="caption">
									<td width="20%">Номер платежа</td>
									<td width="20%">Дата платежа</td>
									<td width="20%">Сальдо на начало</td>
									<td width="20%">Сумма платежа</td>
									<td width="20%">Сальдо на конец</td>
								</tr>%items%
							</table>
						</div>
END;

$FORMS['payments_item'] = <<<END

								<tr class="line">
									<td>%number%</td>
									<td>%date%</td>
									<td>%saldo_na_nachalo%</td>
									<td>%summa_platezha%</td>
									<td>%saldo_na_konec%</td>
								</tr>
END;

$FORMS['payments_block_empty'] = <<<END
						<p>Оплата еще не производилась</p>
END;

$FORMS['balance_minus'] = <<<END
								<span class="user-debts-caption">Ваша текущая задолженность:</span>
								<span class="user-debts-value minus">%total% руб.</span>
								<span class="button account-button" id="open-modal-gotopay" data-target="#modal-gotopay" data-toggle="modal">Оплатить задолженность</span>
END;

$FORMS['balance_plus'] = <<<END
								<span class="user-debts-caption">Ваш баланс составляет:</span>
								<span class="user-debts-value">%total% руб.</span>
								<span class="button account-button" id="open-modal-gotopay" data-target="#modal-gotopay" data-toggle="modal">Пополнить счет</span>
END;

?>