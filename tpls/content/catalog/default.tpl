<?php

$FORMS = Array();

$FORMS['items'] = <<<END
						<ul class="product_listing">%items%
						</ul>
END;
 
$FORMS['item'] = <<<END

							<li>
								<a href="%link%">
									<div class="overlay">%data getProperty(%id%, 'product_discount', 'show_discount')%%data getProperty(%id%, 'exist', 'show_exist')%%data getProperty(%id%, 'product_new', 'show_product_new')%</div>
									<span class="label_price"><i>%data getProperty(%id%, 'price_on_order', 'price_on_order')%</i></span>
									%data getProperty(%id%, 'photo_1', 'image_catalog_listing')%
									<span class="name">%name%</span>
									<span class="size">%data getProperty(%id%, 'hide_razmernost', 'hide_razmernost')%</span>
								</a>
							</li>
END;

$FORMS['block_empty'] = <<<END
<p>В данной категории пока еще нет товаров</p>
END;

$FORMS['categories'] = <<<END

						<ul class="sub_categories">%items%
						</ul>
END;

$FORMS['category'] = <<<END

							<li><a class="button" href="%link%">%text%</a></li>
END;

$FORMS['categories_empty'] = <<<END
END;

?>