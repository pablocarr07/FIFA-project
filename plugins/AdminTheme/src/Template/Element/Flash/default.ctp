<?php
$class = 'message';
if (!empty($params['class'])) {
    $class.= ' ' . $params['class'][4];
}
?>
<div class="alert <?= h($class) ?> alert-dismissible ">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <?= h($message) ?>
</div>