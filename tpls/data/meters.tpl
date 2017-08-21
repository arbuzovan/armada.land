<?php

$FORMS = Array();

$FORMS['meters_grid'] = <<<END
    <div class="table-responsive">
        <table class="table profile-table">
            <tr class="caption">
                <td width="1%">#</td>
                <td width="1%">Номер участка</td>
                <td width="">Период</td>
                <td width="">Показания<br>счетчика (кВт)</td>
                <td width="">Расход за период</td>
                <td width="">Тариф (руб./кВт ч)</td>
                <td width="">Начислено за электроэнергию</td>
                <td width="">&nbsp;</td>
            </tr>
            %lines%
        </table>
    </div>
    <a href="#" class="button account-button editButton addMetersBtn">Добавить показания</a>
END;


$FORMS['meters_grid_line'] = <<<END
    <tr class="line">
        <td class="numberCol" rel="%id%">%number%</td>
        <td class="areaNumberCol" rel="%id%">%area_number%</td>
        <td class="periodCol" rel="%id%">%period%</td>
        <td class="meterCol" rel="%id%">%elektroenergiya_den%</td>
        <td class="deltaCol" rel="%id%">%delta_meter%</td>
        <td class="tarifCol" rel="%id%">%tarif%</td>
        <td >%users getEditTarifButton(%id%)%</td>
    </tr>
END;

?>