<?php

use app\models\Category;
use app\models\Status;
use yii\bootstrap5\Html;
?>
<div class="card m-2" style="width: 18rem;">
<?=Html::img('/img/' . Html::encode($model->image),['style' => 'height:200px','class' => 'card-img-top'])?>
  <div class="card-body">
    <p class="card-text">Временная метка: <?=date('d.m.Y H:i:s', strtotime(Html::encode($model->created_at))) ?></p>
    <p class="card-text">Название: <?=Html::encode($model->title)?></p>
    <p class="card-text">Описание приготовления: <?=Html::encode($model->description)?></p>
    <p class="card-text">Категория: <?=Html::encode(Category::getCategory()[$model->category_id])?></p>
    <p class="card-text">Статус рецепта: <?=Html::encode(Status::getStatus()[$model->status_id])?></p>
    <?= Html::a('Просмотреть', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= $model->status_id == Status::getStatusId('Новый')
     ?Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить?',
                'method' => 'post',
            ],
        ]):''?>
  </div>
</div>