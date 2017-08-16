<?php

$FORMS = Array();

$FORMS['swf_file'] = $FORMS['img_file'] = <<<END
%system makeThumbNailFull('%filepath%', '500', '300', 'clear', '0', '0', '5', '0', '100')%
END;

?>