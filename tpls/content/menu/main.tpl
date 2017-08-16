<?php

$FORMS = Array();

$FORMS['menu_block_level1'] = <<<END
								<ul>%lines%%users auth('account_link')%
								</ul>
END;

$FORMS['menu_line_level1'] = <<<END

									<li><a href="%link%">%text%</a></li>
END;

$FORMS['menu_line_level1_a'] = <<<END

									<li class="active"><a href="%link%">%text%</a></li>
END;


?>