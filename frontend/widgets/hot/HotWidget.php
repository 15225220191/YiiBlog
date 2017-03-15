<?php

namespace frontend\widgets\hot;

/**
 * 热门浏览组件
 */
use Yii;
use yii\base\Widget;
use frontend\models\Posts;
use yii\helpers\Url;
use frontend\models\PostExtends;
use yii\db\Query;

class HotWidget extends Widget {

    /**
     * 文章列表的标题
     * @var unknown
     */
    public $title = '';

    /**
     * 显示条数
     * @var unknown
     */
    public $limit = 2;

    /**
     * 是否显示更多
     * @var unknown
     */
    public $more = true;

    /**
     * 是否显示分页
     * @var unknown
     */
    public $page = true;

    public function run() {
        $res = (new Query())
                ->select('a.browser, b.id, b.title')
                ->from(['a' => PostExtends::tableName()])
                ->join('LEFT JOIN', ['b' => Posts::tableName()], 'a.post_id = b.id')
                ->where('b.is_valid =' . Posts::IS_VALID)
                ->orderBy('browser DESC, id DESC')
                ->limit($this->limit)
                ->all();

        $result['title'] = $this->title? : '热门浏览';
        $more = $this->more = "更多>>";
        $result['more'] = [
            "name" => $more,
            'url'=>Url::to(['article/index', 'sort' => 'hot'])
        ];
        $result['body'] = $res? : [];

        return $this->render('index', ['data' => $result]);
    }

}
