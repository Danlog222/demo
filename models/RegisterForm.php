<?php

namespace app\models;

use Yii;
use yii\helpers\VarDumper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $full_name
 * @property string $login
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property int $role_id
 * @property string $auth_key
 *
 * @property Application[] $applications
 * @property Role $role
 */
class RegisterForm extends \yii\base\Model
{
    public string $full_name ='';
    public string $login ='';
    public string $email ='';
    public string $phone ='';
    public string $password ='';
    public string $password_repeat ='';
    public bool $rules = false;
    /**
     * {@inheritdoc}
     */
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'login', 'email', 'phone', 'password'], 'required'],
            [['full_name', 'login', 'email', 'phone', 'password'], 'string', 'max' => 255],
            [['login'], 'unique','targetClass' => User::class,],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            ['email', 'email'],
            [['rules'],'required','requiredValue' => 1, 'message'=> 'Согласие на обработку персональных данных - должно быть отмечено.'],
            ['full_name', 'match', 'pattern' => '/^[а-яёА-ЯЁ\s\-]+$/u'],
            ['login', 'match', 'pattern' => '/^[a-zA-Z0-9\-]+$/'],
            ['phone', 'match', 'pattern' => '/^\+7\(\d{3}\)\-\d{3}\-\d{2}\-\d{2}$/'],
            ['password', 'match', 'pattern' => '/^[a-zA-Z0-9]+$/i'],
            ['password', 'string', 'min' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'ФИО',
            'login' => 'Логин',
            'email' => 'Email',
            'phone' => 'телефон',
            'password' => 'Пароль',
            'password_repeat' => 'Повтор пароля',
            'rules' => 'персональных данных',
        ];
    }

    public function registerUser(){
        if ($this->validate()) {
           $user = new User();
        $user->attributes = $this->attributes;
        
        $user->password = Yii::$app->security->generatePasswordHash($this->password);
        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->role_id = Role::getRole('user');
        if(!$user->save()){
            return VarDumper::dump($user->errors,10,true);
        }
        }
        return $user ?? false;
        
        
    }
}
