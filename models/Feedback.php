<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "feedback".
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $content
 * @property string $image
 * @property string $created_at
 */
class Feedback extends \yii\db\ActiveRecord
{
    public $imageFile;
    public bool $rules = false;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feedback';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'content'], 'required'],
            [['content'], 'string'],
            [['created_at'], 'safe'],
            [['name', 'phone'], 'string', 'max' => 255],
            ['name', 'match', 'pattern' => '/^[А-ЯЁ][а-яё\-]+\s{2}[А-ЯЁ][А-ЯЁа-яё\-\s]+$/u'],
            ['phone', 'match', 'pattern' => '/^\+7\(\d{3}\)\-\d{3}\-\d{2}\-\d{2}$/'],
            [['rules'],'required','requiredValue' => 1, 'message'=> 'Согласие на обработку персональных данных - должно быть отмечено.'],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpg, jpeg, png, bmp'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'phone' => 'Телефон',
            'content' => 'Отзыв',
            'image' => 'Фото',
            'created_at' => 'Временная метка',
        ];
    }

    public function upload($atribute = 'image')
    {
        $this->$atribute = Yii::$app->security->generateRandomString() . '.' . $this->imageFile->extension;
        if ($this->validate()) {
            $this->imageFile->saveAs('otziv/' . $this->$atribute);
            return true;
        } else {
            return false;
        }
    }
}
