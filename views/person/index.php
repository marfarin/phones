<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PersonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'People');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
<?= Html::a(
    Yii::t('app', 'Create Person'),
    null,
    [
        'class' => 'btn btn-success modalButton',
        'id' => 'modalButton',
        'value' => \yii\helpers\Url::to(['create'])
    ]
) ?>
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
            'last_name',
            'first_name',
            'second_name',
            'phone_number',
            [
                'attribute' => 'spec',
                'value' => 'spec.spec_name'
            ],

            [
                'class' => 'yii\grid\ActionColumn',
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
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
    <?php
        echo Html::beginTag('table', ['id'=>'example']);
        echo Html::beginTag('thead');
        echo Html::beginTag('tr');
        echo Html::tag('th','id');
        echo Html::tag('th','Last Name');
        echo Html::tag('th','First Name');
        echo Html::tag('th','Second Name');
        echo Html::tag('th','Phone Number');
        echo Html::tag('th','Spec Name');
        echo Html::endTag('tr');
        echo Html::endTag('thead');
        echo Html::endTag('table');
    ?>


</div>
