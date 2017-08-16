<?php

$FORMS = Array();

$FORMS['page_template'] = <<<END
%users getReceipts(%user_id%, 'default', '1')%
%users getMeters(%user_id%, 'common', '1')%
END;

$FORMS['meters_block'] = <<<END
						<h2>Показания за %date%</h2>
						<div class="table-responsive">
							<table class="table profile-table">
								<tr class="caption">
									<td width="21%">Номер счетчика</td>
									<td width="23%">Тип счетчика</td>
									<td width="23%">Предыдущие показания</td>
									<td width="23%">Текущие показания</td>
								</tr>%items%
							</table>
						</div>
END;

$FORMS['meters_item'] = <<<END

								<tr class="line">
									<td>%number%</td>
									<td>%title%</td>
									<td>%users getMetersPreview(%id%, %field_name%, 'common')%</td>
									<td>%value% кВт</td>
								</tr>
END;

$FORMS['meters_preview_item'] = <<<END
%value% кВт (%date%)
END;

$FORMS['meters_preview_item_empty'] = <<<END
показаний не было
END;

$FORMS['meters_block_empty'] = <<<END
						<p>Пока нет показаний для отображение</p>
END;

?>