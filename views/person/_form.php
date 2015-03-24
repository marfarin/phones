<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Person */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="person-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'second_name')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'spec_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
