<?php

namespace frontend\models;

use yii\base\Model;
use frontend\models\Feeds;

class FeedsForm extends Model {

    public $content;
    public $_lastError;

    public function rules() {
        return [
            ['content', 'required'],
            ['content', 'string', 'max' => 255],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => "ID",
            "content" => "內容",
        ];
    }

    public function createFeeds() {
        try {
            $model = new Feeds();
            $model->user_id = \Yii::$app->user->identity->id;
            $model->content = $this->content;
            $model->created_at = time();
            if (!$model->save()){
                throw new \Exception('保存失败！');
            }else{
                return true;
            }    
        } catch (\Exception $e) {
            $this->_lastError = $e->getMessage();
            return false;
        }
    }

    public function getList() {
        $model = new Feeds();
        $res = $model->find()->limit(10)
                ->with("user")
                ->orderBy(['id' => SORT_DESC])
                ->asArray()
                ->all();
        return $res? : [];
//        print_r($res? : []);
//        exit;
    }

}

?>