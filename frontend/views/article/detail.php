<?php
$this->title = $data['title'];
$this->params['breadcrumbs'][] = ['label' => "博客", 'url' => ['posts/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-9">
        <div class="page-title">
            <h1><?= $data['title'] ?></h1>
        </div>
        <span>作者:<?= $data['user_name'] ?></span>
        <span>发布事件:<?= date("Y-m-d", $data['created_at']) ?></span>
        <span>浏览次数:<?= $data['extend']['browser'] ?>次</span>
        
        <div class="page-content">
            <?= $data['content'] ?>
        </div>
        
        <div class="page-tag">
            标签:
            <?php foreach($data['tags'] as $tag): ?>
            <span><a href="#"><?= $tag ?></a></span>
            <?php endforeach; ?>
        </div>

    </div>
    <div class="col-lg-3">
        <h1>热门文章</h1>
    </div>
</div>
