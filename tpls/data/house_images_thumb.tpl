<?php

$FORMS = Array();

$FORMS['set_of_images'] = <<<END
%items%
END;

$FORMS['image_item'] = <<<END

							<div class="col-xs-8">
								<div class="item-image" data-slide-id="%offset_num%">
									<img class="img-responsive" src="%system makeThumbNailFull('%filepath%', '200', '150', 'clear', '0', '1', '5', '0', '100')%" alt="%alt%" />
								</div>
							</div>
END;

$FORMS['set_of_images_empty'] = <<<END
END;

$FORMS['swf_file'] = $FORMS['img_file'] = <<<END
%system makeThumbNailFull('%filepath%', '200', '150', 'clear', '0', '1', '5', '0', '100')%
END;

?>