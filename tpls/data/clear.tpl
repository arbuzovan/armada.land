<?php

$FORMS = Array();

$FORMS['int'] = <<<END
%value%
END;

$FORMS['float'] = <<<END
%value%
END;

$FORMS['price'] = <<<END
%value%
END;

$FORMS['string'] = <<<END
%value%
END;

$FORMS['text'] = <<<END
%value%
END;

$FORMS['relation'] = <<<END
%value%
END;

$FORMS['file'] = <<<END
%src%
END;

$FORMS['swf_file'] = $FORMS['img_file'] = <<<END
%src%
END;

$FORMS['date'] = <<<END
%value%
END;

$FORMS['boolean_yes'] = <<<END
Да
END;

$FORMS['boolean_no'] = <<<END
Нет
END;

$FORMS['wysiwyg'] = <<<END
%value%
END;

?>