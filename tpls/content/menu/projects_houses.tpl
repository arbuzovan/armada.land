<?php

$FORMS = Array();

$FORMS['menu_block_level1'] = <<<END
%lines%
END;

$FORMS['menu_line_level1'] = <<<END

						<div class="col-xs-24 col-sm-12 house-item item%data getProperty(%id%, 'technology', 'house_filter_class')%">
							<a href="%link%">
								<div class="image" style="background-image: url(%data getProperty(%id%, 'main_image', 'house_thumb')%);"></div>
								<div class="description">
									<div class="house-about">
										<span class="name">%text%</span>
										<span class="descr">%data getProperty(%id%, 'short_description', 'clear')%</span>
										<span class="area">%data getProperty(%id%, 'area', 'house_params')%</span>
									</div>
								</div>
							</a>
						</div>
END;

?>