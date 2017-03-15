<?php
use yii\helpers\Url;
?>
<?php if(!empty($data)):?>
<div class="panel">
    <div class="panel-title box-title">
        <span><strong><?=$data['title']?></strong>
            <a href="<?= $data['more']['url']?>"><strong><?=$data['more']['name']?></strong></a>
        </span>
        
    </div>
    <div class="panel-body hot-body">
        <?php foreach ($data['body'] as $list):?>
        <div class="clearfix hot-list">
            <div class="pull-left media-left">
                <a href="#">浏览<em><?=$list['browser']?></em></a>
            </div>
            <div class="media-right">
                <a href="<?=Url::to(['article/detail','id'=>$list['id']])?>"><?=$list['title']?></a>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>
<?php endif;?>
