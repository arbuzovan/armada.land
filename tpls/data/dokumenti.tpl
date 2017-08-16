<?php

$FORMS = Array();

$FORMS['set_of_images'] = <<<END
%items%
END;

$FORMS['image_item'] = <<<END

						<div class="col-xs-12 col-sm-6 col-md-4">
							<a href="%src%" class="fancybox" rel="group_%page_id%">
								<img class="img-responsive" src="%system makeThumbNailFull('%filepath%', '170', '240', 'clear', '0', '1', '5', '0', '100')%" alt="%alt%" />
							</a>
						</div>
END;

$FORMS['set_of_images_empty'] = <<<END
END;

?>