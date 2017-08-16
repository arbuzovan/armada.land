<?php

$FORMS = Array();

$FORMS['swf_file'] = $FORMS['img_file'] = <<<END
%system makeThumbNailFull('%filepath%', '370', '250', 'clear', '0', '1', '5', 'false', '100')%
END;

?>