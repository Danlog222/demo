<?php

namespace app\models;

use Yii;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "application".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $category_id
 * @property int $status_id
 * @property int $user_id
 * @property string $image
 * @property string $created_at
 * @property string|null $image_admin
 * @property string|null $reason
 *
 * @property Category $category
 * @property Status $status
 * @property User $user
 */
class Application extends \yii\db\ActiveRecord
{
    public $imageFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'application';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'category_id', 'time_delivery'], 'required'],
            [['description'], 'string'],
            ['time_delivery', 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            ['time_delivery', 'checkDate'],
            ['time_delivery', 'checkTime'],
            [['category_id', 'status_id', 'user_id'], 'integer'],
            [['title', 'image_admin', 'reason'], 'string', 'max' => 255],
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
            'title' => 'Название',
            'description' => 'Описание приготовления',
            'category_id' => 'Категория рецепта',
            'status_id' => 'Статус рецепта',
            'user_id' => 'User ID',
            'image' => 'Фотография',
            'created_at' => 'Временная метка',
            'image_admin' => 'Image Admin',
            'reason' => 'Reason',
            'imageFile' => 'Изображение',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    public function upload()
    {
        $this->image = Yii::$app->security->generateRandomString() . '.' . $this->imageFile->extension;
        if ($this->validate()) {
            $this->imageFile->saveAs('img/' . $this->image);
            return true;
        } else {
            return false;
        }
    }
    public function uploadAdmin($attr = 'image')
    {
        $this->$attr = Yii::$app->security->generateRandomString() . '.' . $this->imageFile->extension;
        if ($this->validate()) {
            $this->imageFile->saveAs('img/' . $this->$attr);
            return true;
        } else {
            return false;
        }
    }

    public function checkDate()
    {
        if ($this->id) {
            $res = self::find()
                ->where(['time_delivery' => $this->time_delivery])
                ->andWhere(['!=', 'id', $this->id])
                ->count();
            if ($res) {
                $this->addError('time_delivery', 'мяу');
            }
        }
    }

    public function checkTime(){
        $hour = (int)Yii::$app->formatter->asTime($this->time_delivery, 'php:H');
        $minute = (int)Yii::$app->formatter->asTime($this->time_delivery, 'php:i');

        if($hour < 8 || $hour > 12 || !empty($minute)){
            $this->addError('time_delivery', 'qwsdsvsdv');
        }
    }
}
