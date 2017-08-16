<?php

$FORMS = Array();

$FORMS['set_of_images'] = <<<END

				<div class="gallery">
					<div class="container">
						<div class="row">
							<div class="col-xs-24">
								<h2>Ход строительства поселка</h2>
								<p>Представляем Вашему вниманию фотогалерею хода строительства поселка.</p>
							</div>
						</div>
					</div>
					<div id="owl-construction" class="owl-carousel">%items%
					</div>
				</div>
END;

$FORMS['image_item'] = <<<END

						<div class="item">
							<a href="%src%" class="fancybox" rel="construction" title="%alt%">
								<img class="img-responsive" src="%system makeThumbNailFull('%filepath%', '450', '450', 'clear', '0', '1', '5', '0', '100')%" alt="%alt%" />
							</a>
						</div>
END;

$FORMS['set_of_images_empty'] = <<<END
END;

?>