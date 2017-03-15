<?php
namespace frontend\widgets\article;
use yii\base\Widget;
use frontend\models\Posts;
use frontend\models\PostsForm;
use yii\data\Pagination;
use yii\helpers\Url;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of articleWidgets
 *
 * @author Administrator
 */
class ArticleWidgets extends Widget {
    //文章标题
    public $title;
    //显示几条
    public $limit = 2;
    //显示更多
    public $more =true;
    //显示分页
    public $page = true;
//    public function init() {

//    }
    public function run() {
        //1.获取当前页,默认显示第一页
        $currentPage = \Yii::$app->request->get("page",1);
        //查询所有可见文章
        $condition = ['=','is_valid',  Posts::IS_VALID];
        //3.由表单模型根据条件查询符合的文章数据
        $res = PostsForm::getArticleList($condition,$currentPage,  $this->limit);
        $result['title'] = $this->title ? : "最新文章";
        $result['more'] = Url::to(['article/index']);
        $result['body'] = $res['data']? : [];
        if($this->page){
            $pages = new Pagination(['totalCount' => $res['count'],'pageSize' => $res['pageSize']]);
            $result['page'] = $pages;
        }  else {
            
        }
        return $this->render("index",['data' => $result]);
    }
}
