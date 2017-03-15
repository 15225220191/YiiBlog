<?php

namespace frontend\controllers;

use frontend\models\PostsForm;
use frontend\models\Cats;
use frontend\models\PostExtends;
use frontend\models\Posts;
use frontend\widgets\article\ArticleWidgets;
use yii\data\Pagination;
class ArticleController extends \yii\web\Controller {
    public $page = true;
    public function actionIndex() {
        //实例化表单模型;
        $limit = new ArticleWidgets();
        $PostsForm = new PostsForm();
        //获取当前页,默认显示第一页
//        $currentPage = \Yii::$app->request->get("page",1);
        //查询所有符合条件的文章
        $condition = ['=','is_valid',Posts::IS_VALID];
        $res = $PostsForm ->getArticleList($condition,$limit->limit);
        if($limit->page){
            $pages = new Pagination(['totalCount' => $res['count'],'pageSize' => $res['pageSize']]);
            $res['page'] = $pages;
        }  else {
            
        }
//        echo '<pre>';
//        print_r($res);
//        exit();
        return $this->render('index',['data' => $res]);
    }

    public function actionAdd() {
        $model = new PostsForm();
        $model->setScenario(PostsForm::SCENARIOS_CREATE);
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->createArticle()) {
                return $this->redirect(['article/detail','id' => $model->id]);
            } else {
                echo '保存失败';
            }
            $catlist = Cats::getCategoryList();
            return $this->render("create",['model' => $model,'catlist' => $catlist]);
        }
        
        $cats[0] = "默认分类";
        $categorys = Cats::find()->asArray()->all();
        // 对查询到的数据做处理,将二维数组转化为一维数组
        if ($categorys) {
            foreach ($categorys as $k => $v) {
                // $v  一行  2字段
                $id = $v['id'];
                $cats[$id] = $v['cat_name'];
            }
        }
        return $this->render("add", ['model' => $model,"categorys" => $cats,]);
    }
    public function actionDetail(){
        $model = new PostsForm();
        $data = $model->getArticleById(\Yii::$app->request->get("id"));
        
        $model1 = new PostExtends();
        //自定义方法,每次调用+1
        $model1-> upCounter(['post_id' => \Yii::$app->request->get("id")],'browser',1);
        
        return $this->render("detail",['data' => $data]);
    }

    public function actions() {
        return [
            'upload' => [
                'class' => 'common\widgets\file_upload\UploadAction', //这里扩展地址别写错
                'config' => [
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}",
                ]
            ],
            'ueditor' => [
                'class' => 'common\widgets\ueditor\UeditorAction',
                'config' => [
                    //上传图片配置
                    'imageUrlPrefix' => "", /* 图片访问路径前缀 */
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
                ]
            ]
        ];
    }

}
