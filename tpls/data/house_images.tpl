<?php

$FORMS = Array();

$FORMS['set_of_images'] = <<<END
%items%
END;

$FORMS['image_item'] = <<<END

									<li><a class="fancybox" href="%src%" rel="house"><img class="img-responsive" src="%system makeThumbNailFull('%filepath%', '500', '300', 'clear', '0', '1', '5', '0', '100')%" alt="%alt%" /></a></li>
END;

$FORMS['set_of_images_empty'] = <<<END
END;

?>