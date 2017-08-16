<?php

$FORMS = Array();

$FORMS['login'] = <<<END
END;

$FORMS['logged'] = <<<END

								<div class="row information-item">
									<div class="col-xs-24 col-sm-12">Номер лицевого счета:</div>
									<div class="col-xs-24 col-sm-12"><strong>%data getPropertyOfObject(%user_id%, 'payment_number', 'clear')%</strong></div>
								</div>
								<div class="row information-item">
									<div class="col-xs-24 col-sm-12">Фамилия Имя Отчество собственника:</div>
									<div class="col-xs-24 col-sm-12"><strong>%data getPropertyOfObject(%user_id%, 'fname', 'clear')% %data getPropertyOfObject(%user_id%, 'lname', 'clear')% %data getPropertyOfObject(%user_id%, 'father_name', 'clear')%</strong></div>
								</div>
								<div class="row information-item">
									<div class="col-xs-24 col-sm-12">Адрес участка:</div>
									<div class="col-xs-24 col-sm-12">%data getPropertyOfObject(%user_id%, 'place_name', 'clear')%, участок %data getPropertyOfObject(%user_id%, 'area_number', 'clear')%</div>
								</div>
								<div class="row information-item">
									<div class="col-xs-24 col-sm-12">Площадь участка:</div>
									<div class="col-xs-24 col-sm-12">%data getPropertyOfObject(%user_id%, 'place_area', 'clear')% %custom declOfNum(%data getPropertyOfObject(%user_id%, 'place_area', 'clear')%)%</div>
								</div>
								<div class="row information-item">
									<div class="col-xs-24 col-sm-12">Текущий e-mail:</div>
									<div class="col-xs-24 col-sm-12"><span class="link">%data getPropertyOfObject(%user_id%, 'e-mail', 'clear')%</span></div>
								</div>
END;

?>