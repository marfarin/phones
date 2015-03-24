<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Log */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'insert_time')->textInput() ?>

    <?= $form->field($model, 'table_name')->dropDownList([ 'persons' => 'Persons', 'spec' => 'Spec', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'object_id')->textInput() ?>

    <?= $form->field($model, 'operation_type')->dropDownList([ 'INSERT' => 'INSERT', 'UPDATE' => 'UPDATE', 'DELETE' => 'DELETE', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'old_value')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'new_value')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
