<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "post_extends".
 *
 * @property integer $id
 * @property integer $post_id
 * @property integer $browser
 * @property integer $collect
 * @property integer $praise
 * @property integer $comment
 */
class PostExtends extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_extends';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'browser', 'collect', 'praise', 'comment'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'post_id' => Yii::t('common', 'Post ID'),
            'browser' => Yii::t('common', 'Browser'),
            'collect' => Yii::t('common', 'Collect'),
            'praise' => Yii::t('common', 'Praise'),
            'comment' => Yii::t('common', 'Comment'),
        ];
    }
    // 参数1 根据条件找到某个文章
    // 参数2 让文章的那个属性自增
    // 参数3 让自增的值为多少，默认为1
    // 目的：让函数具备通用性
    public function upCounter($condition,$attribute,$num){
        // 1 查询扩展表
        // 条件 一般是 id=5
        $article = $this->findOne($condition);
        // 1) 文章已经存在，让浏览量在原先的基础上+1
        if($article){
            // 属性名 browser
            // 
            $data[$attribute] = $num;
            $article->updateCounters($data);
        }
        // 2) 文章没存储过，让浏览量默认为1
        else {
            $this->setAttributes($condition);
            $this->$attribute = 1;
            $this->save();
        }
        // 2 评论数+1，点赞+1，收藏+1，
        
        
        
    }
}
