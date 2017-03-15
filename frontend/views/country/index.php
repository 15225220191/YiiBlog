<?php 
use yii\widgets\LinkPager;
?>

<?php foreach ($countrys as $key => $value) { ?>
    <h1><?= $value['code'] ?> ----- <?= $value['name'] ?></h1>
<?php } ?>
<div id="pagination1">   <?= LinkPager::widget(['pagination' => $pagination]) ?>  </div>
<hr>

<?php foreach ($countrys as $key => $value): ?>
    <h1><?= $value['code'] ?> ----- <?= $value['name'] ?></h1>
<?php endforeach; ?>
