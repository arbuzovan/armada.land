<?php

$FORMS = Array();

$FORMS['swf_file'] = $FORMS['img_file'] = <<<END
%system makeThumbNailFull('%filepath%', '258', '150', 'clear', '0', '1', '5', 'false', '100')%
END;

$FORMS['swf_file_empty'] = $FORMS['img_file_empty'] = <<<END
/images/template/baloon_default.jpg
END;

?>