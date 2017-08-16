<?php

$FORMS = Array();

$FORMS['page_template'] = <<<END
							<h2>История платежей</h2>
%users getHistoryPayments(%user_id%)%
END;

$FORMS['payments_fail'] = <<<END
							<h2>История платежей</h2>
							<div class="payments-fail">По техническим причинам платеж не был проведен. Пожалуйста повторите попытку немного позднее.</div>
%users getHistoryPayments(%user_id%)%
END;

?>