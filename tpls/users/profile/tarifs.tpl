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
            <td width="5%">&nbsp;</td>
        </tr>
        %lines%
    </table>
</div>
END;

$FORMS['tarifs_grid_line'] = <<<END
<tr class="line">
    <td class="numberCol" rel="%id%">%number%</td>
    <td class="nameCol" rel="%id%">%name%</td>
    <td class="tarifCol" rel="%id%">%tarif%</td>
    <td >%users getEditTarifButton(%id%)%</td>
</tr>
END;

$FORMS['editTarifButton'] = <<<END
    <a class="button account-button editButton tarifEditBtn" href="#" rel="%id%">Редактировать</a>
END;

?>