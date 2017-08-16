<?php

$FORMS = Array();

$FORMS['group'] = <<<END
								<ul class="params-list-main">%lines%
								</ul>
END;

$FORMS['group_line'] = <<<END

									<li>%prop%</li>
END;

$FORMS['int'] = <<<END
%title%<span>%value%</span>
END;

$FORMS['float'] = <<<END
%title%<span>%value% м<sup>2</sup></span>
END;


$FORMS['price'] = <<<END
%title%<span>%value% руб</span>
END;

$FORMS['string'] = <<<END
%title%<span>%value%</span>
END;

?>