<?php

namespace frontend\models;

use yii\base\Model;

class TagsForm extends Model {

    public $id;
    public $tags;

    public function rules() {
        return [
            ['tags', 'required'],
            ['tags', 'each', 'rule' => ['string']],
        ];
    }

    public function saveTags() {
        $ids = [];
        if (!empty($this->tags)) {
            foreach($this->tags as $k => $v) {
                $ids[] = $this->_saveTag($v);
            }
        }
        return $ids;
    }
    
    private function _saveTag($v) {
        $model = new Tags();
        $res = $model->find()->where(['tag_name' => $v])->one();
        if (!$res) {
            $model->tag_name = $v;
            $model->post_num = 1;
            if (!$model->save()) {
                throw new Exception("保存失败");
            }
            return $model->id;
        }   else {
            $res->updateCounters(['post_num' => 1]);
        }
        return $res->id;
    }

}
