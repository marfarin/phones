<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\Person */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="person-form">

    <?php $form = ActiveForm::begin(
        [
            'id' => 'form-person-modal',
            'enableAjaxValidation' => true,
        ]
    );
    $url = \yii\helpers\Url::to(['list', 'name' => 'Spec']);
    $initScript = <<< SCRIPT
            function (element, callback) {
                var id=\$(element).val();
                if (id !== "") {
                    \$.ajax("{$url}&id=" + id, {
                        dataType: "json"
                    }).done(function(data) { callback(data.results);});
                }
            }
SCRIPT;
    echo $form->field($model, 'last_name')->textInput(['maxlength' => 100]);

    echo $form->field($model, 'first_name')->textInput(['maxlength' => 100]);

    echo $form->field($model, 'second_name')->textInput(['maxlength' => 100]);

    echo $form->field($model, 'phone_number')->textInput(['maxlength' => 20]);

    echo $form->field($model, 'spec_id')->widget(\kartik\select2\Select2::className(), [
        'options' => ['placeholder' => 'Поиск родительских компаний'],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 3,
            'ajax' => [
                'url' => $url,
                'dataType' => 'json',
                'data' => new JsExpression('function(term,page) { return {search:term}; }'),
                'results' => new JsExpression('function(data,page) { return {results:data.results}; }'),
            ],
            'initSelection' => new JsExpression($initScript)
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php

    ActiveForm::end(); ?>

</div>
