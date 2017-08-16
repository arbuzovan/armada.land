<?php

$FORMS = Array();

$FORMS['boolean_yes'] = <<<END
<div class=\'balloonContent\'><div class=\'image\'><img src=\'%data getProperty(%pid%, baloon_image, baloon_image)%\' alt=\'%header%\' /></div><div class=\'description\'><div class=\'area_name\'>Участок №%number%</div><div class=\'area_value\'>%area% %custom declOfNum(%area%)%</div><div class=\'price\'><span>Стоимость:</span>%custom priceFormat(%price%)% руб</div><div class=\'btn\'><a href=\'#pp_orderplace\' class=\'fancybox_popup button button_green\'>Забронировать</a><div></div></div>
END;

$FORMS['boolean_no'] = <<<END
<div class=\'balloonContent\'><div class=\'image\'><img src=\'%data getProperty(%pid%, baloon_image, baloon_image)%\' alt=\'%header%\' /></div><div class=\'description\'><div class=\'area_name\'>Участок №%number%</div><div class=\'area_value\'>%area% %custom declOfNum(%area%)%</div><div class=\'btn\'><span class=\'button button_buy\' style=\'background: %data getProperty(%id%, state, place_fill_color)%\'>%data getProperty(%id%, state, clear)%</span><div></div></div>
END;

?>