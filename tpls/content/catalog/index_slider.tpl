<?php

$FORMS = Array();

$FORMS['items'] = <<<END
				<ul id="index-slider" class="bxslider">%items%
				</ul>
END;
 
$FORMS['item'] = <<<END

					<li style="background-image: url(%data getProperty(%id%, 'banner', 'clear')%);">
						<div class="slider-content">
							<div class="text-block">
%data getProperty(%id%, 'slider_text', 'clear')%
<p>&nbsp;</p>
<p><a href="%content get_page_url(%id%)%" class="button button_blue button_square" onclick="yaCounter43099904.reachGoal('full-view'); return true;">Подробнее</a></p>
							</div>
						</div>
					</li>
END;

$FORMS['block_empty'] = <<<END
END;

?>