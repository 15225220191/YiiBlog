<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Posts */

$this->title = Yii::t('common', 'Create Posts');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
