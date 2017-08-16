<?php

$FORMS = Array();

$FORMS['navibar'] = <<<NAVIBAR
			<div class="breadcrumb">
				<a href="/">Главная</a> &nbsp;&mdash;&nbsp; %elements%
			</div>			
NAVIBAR;

$FORMS['element'] = '<a href="%pre_lang%%link%">%text%</a>';

$FORMS['element_active'] = "<span>%text%</span>";

$FORMS['quantificator'] = " &nbsp;&mdash;&nbsp; ";

$FORMS['navibar_empty'] = <<<NAVIBAR
NAVIBAR;

?>
