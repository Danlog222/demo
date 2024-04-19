<?php

use app\models\Category;
use app\models\Status;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Application $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="application-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'title',
                'value' => Html::encode($model->title)
            ],
            [
                'attribute' => 'description',
                'value' => Html::encode($model->description)
            ],
            [
                'attribute' =>'category_id',
                'filter' => Category::getCategory(),
                'value' => Html::encode(Category::getCategory()[$model->category_id]),
            ],
            [
                'attribute' => 'status_id',
                'filter' => Status::getStatus(),
                'value' => Html::encode(Status::getStatus()[$model->status_id]),
            ],
            [
                'attribute' =>'image',
                'filter' => false,
                'format' => 'html',
                'value' => Html::img('/img/' . Html::encode($model->image),['class' => 'w-25']),
            ],
            [
                'attribute' => 'created_at',
                'filter' => false,
                'value' => date('d.m.Y H:i:s', strtotime(Html::encode($model->created_at)))
            ],
           [
            'attribute' => 'image_admin',
            'filter' => false,
            'visible' => (bool)(Html::encode($model->image_admin)),
            'value' => (Html::encode($model->image_admin))
           ],
           [
            'attribute' =>'reason',
            'filter' => false,
            'visible' => (bool) Html::encode($model->reason),
            'value' => (Html::encode($model->reason))
           ],
            
           
        ],
    ]) ?>

</div>
