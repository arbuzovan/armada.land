<?php

$FORMS = Array();

$FORMS['set_of_images'] = <<<END
%items%
END;

$FORMS['image_item'] = <<<END

	<a href="%system makeThumbNailFull('%filepath%', '1000', '1000', 'clear', '0', '1', '5', 'false', '100')%" class="fancybox" rel="construction" title="%alt%"><img src="%system makeThumbNailFull('%filepath%', '105', '105', 'clear', '0', '1', '5', 'false', '100')%" alt="%alt%" /></a>
END;

$FORMS['set_of_images_empty'] = <<<END
END;

?>