<?php

namespace frontend\models;

use yii\base\Model;

// 数据模型 继承自 ActiveRecord
// 表单模型 继承自 Model
// ActiveRecord  ---->  Model
class PostsForm extends Model {

    // 1, 声明属性
    public $id;
    public $title;
    public $content;
    public $label_img;
    public $cat_id;
    public $tags;
    public $_lastError;

    // 声明两个常量,表示添加和更新操作
    const SCENARIOS_CREATE = "create";
    const SCENARIOS_UPDATE = "update";
    // 声明两个常量
    const EVENT_AFTER_CREATE = 'create';
    const EVENT_AFTER_UPDATE = 'update';

    public function scenarios() {
        $scenarios = [
            self::SCENARIOS_CREATE => ['title', 'content', 'label_img', 'cat_id', 'tags'],
            self::SCENARIOS_UPDATE => ['title', 'content', 'label_img', 'cat_id', 'tags'],
        ];
        return array_merge(parent::scenarios(), $scenarios);
    }

    // 2. 设置验证规则
    public function rules() {
        // parent::rules();
        return [
            [['id', 'title', 'content', 'cat_id'], 'required'],
            [['id', 'cat_id'], 'integer'],
            ['title', 'string', 'min' => 4, 'max' => 50],
        ];
    }

    // 3.多语言国际化
    public function attributeLabels() {
        return [
            'title' => \Yii::t("common", "article title"),
            'content' => \Yii::t("common", "article content"),
            'cat_id' => \Yii::t("common", "article cat_id"),
            'label_img' => \Yii::t("common", "article label_img"),
            'tags' => \Yii::t("common", "article tags"),
        ];
    }

    // 4.保存数据到数据库
    // 4.1 添加文章基本信息
    // 4.2 添加文章的标签
    // 注意:如果文章加成功,标签没成功,把数据回滚,类似于撤销上一步
    // 数据库自带的功能  事务 
    // 1) 开启事务
    // 2) 执行相关操作
    // 3) 如果没问题,提交事务(提交后sql语句才会生效)
    // 4) 如果有问题,回滚
    public function createArticle() {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $article = new Posts();
            // 保存表单数据:标题,缩略图,内容,分类,标签
            $article->setAttributes($this->attributes);
            // 手动存储其它数据:创建时间,更新时间,作者,作者id,是否可见,....
            $article->created_at = time();
            $article->updated_at = time();
            $article->summary = "文章简介,从文章中截取前50个字节";
            $article->user_id = \Yii::$app->user->identity->id;
            $article->user_name = \Yii::$app->user->identity->username;
            // 1表示可见  0表示不可见
            $article->is_valid = Posts::IS_VALID;
            if (!$article->save()) {
                throw new Exception("存储失败了");
            }
            $transaction->commit();
            $this->id = $article->id;
            $data = array_merge($this->getAttributes(),$article->getAttributes());
            // 说明:一个合格的函数,长度不应该超过100行
            $this->_eventAfterToDo($data);
            return true;
        } catch (Exception $ex) {
            $transaction->rollBack();
            $this->_lastError = $ex->getMessage();
            return false;
        }
    }
    
    // 私有函数前加_是默认规则
    // 私有函数/私有属性 一般是private,不一定非要用private
    // public private protected
    public function _eventAfterToDo($data) {
        // 设计模式:通知模式
        // on 绑定事件,这个事件并没有执行
        // 说明:可以绑定多个事件
        // 注意:一般来说,绑定事件要在init中实现
        $this->on(self::EVENT_AFTER_CREATE, [$this, '_saveTags'], $data);
        // off 解除事件
        // $this->off($name);

        // 事件执行:执行该字符串上的所有绑定事件
        $this->trigger(self::EVENT_AFTER_CREATE);
    }

    public function _saveTags($event) {
        $tags = new TagsForm();
        $tags->tags = $event->data['tags'];
        $tagids = $tags->saveTags();
        RelationPostTags::deleteAll(['post_id' => $event->data['id']]);
        if (!empty($tagids)) {
            foreach($tagids as $k => $v) {
                $row[$k]['post_id'] = $this->id;
                $row[$k]['tag_id'] = $v;
            }
            $res = (new \yii\db\Query())->createCommand()->batchInsert(RelationPostTags::tableName(), ['post_id','tag_id'], $row)->execute();
            if (!$res) {
                throw new Exception("关联关系保存失败");
            }
        }
    }
    public function getArticleById($id){
        $data = Posts::find()->with('relate.tag','extend')->where(['id'=>$id])->asArray()->one();
        if(!$data){
            throw new \yii\web\NotFoundHttpException("文章不存在");
            
        }
        //对查询到的数据进行处理
        $data['tags'] = [];
        if(isset($data['relate']) && !empty($data['relate'])){
            foreach($data['relate'] as $k => $v) {
                $data['tags'][] = $v['tag']['tag_name'];
            }
        }
        unset($data['relate']);
        return $data;
    }
    public function getArticleList($condition,$page=1,$limit=10,$orderBy=['id'=>SORT_DESC]){
        $model = new Posts();
        
        $query =$model->find()->where($condition)->with('relate.tag','extend')->orderBy($orderBy);
        //获取分页数据
        
        $res = $model->getPages($query);
        //数据格式化
        $res['data'] = self::_formatList($res['data']);
        return $res;
    }
    
    private static function _formatList($data){
        foreach ($data as &$list){
            $list['tag'] = [];
            if(isset($list['relate']) && !empty($list['relate'])){
                foreach ($list['relate'] as $lt){
                    $list['tags'][] = $lt['tag']['tag_name'];
                    
                }
            }
            unset($list['relate']);
        }
        return $data;
    }
}
