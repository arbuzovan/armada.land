<?php

$FORMS = Array();

$FORMS['boolean_yes'] = <<<END

							<div class="discount">
%data getProperty(%id%, 'discount_text', 'clear')%
							</div>
END;

$FORMS['boolean_no'] = <<<END
END;

?>