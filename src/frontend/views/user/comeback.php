<?php
$js = <<<JS
history.back($back)
JS;
$this->registerJs($js);
?>