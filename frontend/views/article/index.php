
<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;
use frontend\widgets\article\ArticleWidgets;
?>
<div class="panel">
    
    <div class="new-list">
        <?php foreach ($data['data'] as $list): ?>
            <div class="panel-body border-bottom">      
                <div class="row">
                    <div class="col-lg-4 label-img-size">
                        <a href="#" class="post-label">
                            <img src="<?= ($list['label_img'] ? 'http://www.yiiblog.io'. $list['label_img'] : \Yii::$app->params['default_label_img']) ?>" alt="<?= $list['title'] ?>">
                        </a>
                    </div>
                    <div class="col-lg-8 btn-group">
                        <h1><a href="<?= Url::to(['article/detail', 'id' => $list['id']]) ?>"><?= $list['title'] ?></a></h1>
                        <span class="post-tags">
                            <span class="glyphicon glyphicon-user"></span><a href="<?= Url::to(['member/index', 'id' => $list['user_id']]) ?>"><?= $list['user_name'] ?></a>&nbsp;
                            <span class="glyphicon glyphicon-time"></span><?= date('Y-m-d', $list['created_at']) ?>&nbsp;
                            <span class="glyphicon glyphicon-eye-open"></span><?= isset($list['extend']['browser']) ? $list['extend']['browser'] : 0 ?>&nbsp;
                            <span class="glyphicon glyphicon-comment"></span><a href="<?= Url::to(['post/detail', 'id' => $list['id']]) ?>"><?= isset($list['extend']['comment']) ? $list['extend']['comment'] : 0 ?></a>
                        </span>
                        <p class="post-content"><?= $list['summary'] ?></p>
                        <a href="<?= Url::to(['post/detail', 'id' => $list['id']]) ?>"><button class="btn btn-warning no-radius btn-sm pull-right">阅读全文</button></a>
                    </div>
                </div>
                <div class="tags">
                    <?php if (!empty($list['tags'])): ?>
                        <span class="fa fa-tags"></span>
                        <?php foreach ($list['tags'] as $lt): ?>
                            <a href="#"><?= $lt ?></a>，
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>            
    </div>
    <?php if ($this->context->page): ?>
        <div class="page"><?= LinkPager::widget(['pagination' => $data['page']]); ?></div>
    <?php endif; ?>
</div>

