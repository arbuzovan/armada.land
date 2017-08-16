<?php

$FORMS = Array();

$FORMS['login'] = <<<END
%data getProperty('1', 'footer_slogan', 'clear')%
END;

$FORMS['logged'] = <<<END
%data getProperty('1', 'requisites', 'clear')%
END;

?>