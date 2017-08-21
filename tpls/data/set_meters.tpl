<?php

$FORMS = Array();

$FORMS['page_template'] = <<<END
    %data crudMeters('meters', 'GET')%
END;

?>