<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SpecSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Specs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spec-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Spec'), null, ['class' => 'btn btn-success modalButton', 'value' => \yii\helpers\Url::to(['create'])]) ?>
    </p>
    <?php Modal::begin([
        'id' => 'modal',
    ]);

    echo "<div id='modalContent'></div>";

    Modal::end();
    Pjax::begin(['id' => 'user-grid']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'spec_name',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '#',
                            [
                                'title' => Yii::t('yii', 'View'),
                                'class' => 'modalButton ',
                                'value' => $url . '&ajax=true',
                                'data-pjax' => '0',
                            ]
                        );
                    },
                    'update' => function ($url) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            '#',
                            [
                                'title' => Yii::t('yii', 'Update'),
                                'class' => 'modalButton ',
                                'value' => $url . '&ajax=true',
                                'data-pjax' => '0',

                            ]
                        );
                    },
                ]],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

</div>
