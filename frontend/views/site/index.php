<?php
use frontend\widgets\banner\BannerWidget;
use frontend\widgets\hot\HotWidget;
use frontend\widgets\tag\TagWidget;
use frontend\widgets\article\ArticleWidgets;
use frontend\widgets\chat\ChatWidget;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';

?>
<div class="col-lg-9">
    <?=BannerWidget::widget()?>
    <?=ArticleWidgets::widget()?>
</div>
<div class="col-lg-3">
    <?=BannerWidget::widget()?>
    <?=HotWidget::widget()?>
    <?=TagWidget::widget()?>
    <?=ChatWidget::widget()?>
</div>