<?php

$FORMS = Array();

$FORMS['menu_block_level1'] = <<<END
							<!--noindex-->
							<ul>%lines%%users auth('account_link')%
							</ul>
							<!--/noindex-->
END;

$FORMS['menu_line_level1'] = <<<END

								<li><a rel="nofollow" href="%link%">%text%</a></li>
END;

$FORMS['menu_line_level1_a'] = <<<END

								<li><a rel="nofollow" href="%link%">%text%</a></li>
END;


?>