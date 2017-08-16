<?php

$FORMS = Array();

$FORMS['guide_block'] = <<<END
							<li><span class="button button-transparent active" data-filter="*">Все</span></li>%lines%
END;

$FORMS['guide_item'] = <<<END

							<li><span class="button button-transparent" data-filter=".type_%id%">%text%</span></li>
END;

?>