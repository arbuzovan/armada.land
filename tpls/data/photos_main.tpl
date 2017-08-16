<?php

$FORMS = Array();

$FORMS['set_of_images'] = <<<END
					<div id="owl-gallery" class="owl-carousel">%items%
					</div>
END;

$FORMS['image_item'] = <<<END

						<div class="item">
							<a href="%src%" class="fancybox" rel="group">
								<img class="img-responsive" src="%system makeThumbNailFull('%filepath%', '450', '450', 'clear', '0', '1', '5', '0', '100')%" alt="photo" />
							</a>
						</div>
END;

$FORMS['set_of_images_empty'] = <<<END
END;

?>