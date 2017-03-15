<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "feeds".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $content
 * @property integer $created_at
 */
class Feeds extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'feeds';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'content', 'created_at'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['content'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('common', 'ID'),
            'user_id' => Yii::t('common', 'User ID'),
            'content' => Yii::t('common', 'Content'),
            'created_at' => Yii::t('common', 'Created At'),
        ];
    }

    public function getList() {
        $model = new FeedModel();
        $res = $model->find()->limit(10)->with('user')->orderBy(['id' => SORT_DESC])->asArray()->all();
        return $res? : [];
    }

    public function getUser() {
        return $this->hasOne(\mdm\admin\models\User::className(), ['id' => 'user_id']);
    }

}
