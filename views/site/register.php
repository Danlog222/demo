<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var ActiveForm $form */
$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-register">
<h1><?= Html::encode($this->title) ?></h1>


    <?php $form = ActiveForm::begin([
    'id' => 'registration-form',
]); ?>

        <?= $form->field($model, 'full_name') ?>
        <?= $form->field($model, 'login', ['enableAjaxValidation' => true]) ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::class, [
    'mask' => '+7(999)-999-99-99',
]) ?> 
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'password_repeat')->passwordInput() ?>
        <?= $form->field($model, 'rules')->checkbox() ?>
    
        <div class="form-group">
            <?= Html::submitButton('Зарегестрироваться', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-register -->
