<?php

namespace frontend\models;

use yii\base\Model;
use frontend\models\User;

/**
 * Signup form
 */
class SignupForm extends Model {

    public $username;
    public $email;
    public $password;
    public $password1;
    public $code;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\frontend\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\frontend\models\User', 'message' => 'This email address has already been taken.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password1', 'required'],
            ['password1', 'string', 'min' => 6],
            ['password1', 'compare', 'compareAttribute' => 'password', 'message' => \Yii::t("common", "psw1 != psw2")],
            ['code', 'required'],
            ['code', 'captcha'],
                // ['code', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels() {
        parent::attributeLabels();

        return [
            "username" => \Yii::t("common", "username"),
            "password" => \Yii::t("common", "password"),
            "password1" => \Yii::t("common", "password1"),
            "email" => \Yii::t("common", "email"),
            "code" => \Yii::t("common", "code"),
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup() {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        return $user->save() ? $user : null;
    }

}
