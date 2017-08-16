<?php

$FORMS = Array();

$FORMS['login'] = <<<END
END;

$FORMS['logged'] = <<<END
    %users getStaffMenu('accountMenuStaff')%
END;

$FORMS['moderator'] = <<<END
    <div class="account-menu hidden-xs hidden-sm hidden-md">
        <div class="container">
            <div class="row">
                <div class="col-xs-20 left">
                    <ul>
                        <li%custom getProfileActiveClass('meters')%><a href="/users//">Показания счетчиков</a></li>
                        <li%custom getProfileActiveClass('meters')%><a href="/users/tarifs/">Тарифы на услуги</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
END;

$FORMS['admin'] = <<<END
END;

?>