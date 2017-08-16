<?php

$FORMS = Array();

$FORMS['block'] = <<<END
%pages%
%system numpages(%total%, %per_page%)%
END;

$FORMS['page'] = <<<END

					<div class="row documents-row">
						<div class="col-xs-24">
							<h2>%name%</h2>
						</div>
						%custom PropertySetOfImages(%id%, 'dokumenti', 'dokumenti')%
					</div>
END;

$FORMS['empty'] = <<<END
					<div class="row">	
						<div class="col-xs-24">
							<p>Документы еще не добавлены</p>
						</div>
					</div>
END;

?>