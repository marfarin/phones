<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Spec */

$this->title = Yii::t('app', 'Create Spec');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Specs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spec-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
