<?php

$FORMS = Array();

$FORMS['page_template'] = <<<END
%users getTarifs(%tarifs_guide_id%)%
END;


$FORMS['tarifs_grid'] = <<<END
Тарифы
<div class="table-responsive">
    <table class="table profile-table">
        <tr class="caption">
            <td width="10%">#</td>
            <td width="43%">Наименование</td>
            <td width="23%">Тариф, руб.</td>
        </tr>
        %lines%
    </table>
</div>
END;

$FORMS['tarifs_grid_line'] = <<<END
<tr class="line">
    <td>%number%</td>
    <td>%name%</td>
    <td>%tarif%</td>
</tr>
END;

?>