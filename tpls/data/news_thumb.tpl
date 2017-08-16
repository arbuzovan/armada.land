<?php

$FORMS = Array();

$FORMS['swf_file'] = $FORMS['img_file'] = <<<END
%system makeThumbNailFull('%filepath%', '270', '270', 'clear', '0', '1', '5', '0', '100')%
END;

?>