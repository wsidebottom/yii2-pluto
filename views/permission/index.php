<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\BaseDataProvider */
/* @var $context yii\web\Controller */

/* @link https://github.com/softark/yii2-dual-listbox */

$context = $this->context;
$viewOptions = $context->module->viewOptions;

$this->title = 'Permissions';
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['role/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= $this->title ?></h1>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
            'contentOptions' => [ 'class' => 'text-info' ]
        ],

        [
            'attribute' => 'name',
            'label' => 'Name',
            'content' => function($model, $key, $index, $widget)    {
                return Html::a($model->name, [ 'update', 'id' => $model->name ]);
            },
            'format' => 'html',
        ],
        'description:text:' . 'Description',
        'ruleName:text:' . 'Condition',
//        'data',
//        'createdAt:datetime',
//        'updatedAt:datetime',

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}'
        ],
    ],
    'formatter' => [
        'class' => 'yii\i18n\Formatter',
        'datetimeFormat' => 'short', // 'dd-MM-yyyy HH:mm:ss'
        'nullDisplay' => '',
    ],
    'tableOptions' => ['class' => 'table table-sm table-bordered'],
    'summary' => '<div class="small text-info">{begin}-{end}/{totalCount}</div>',
    'emptyText' => 'none',
    'emptyTextOptions' => [ 'class' => 'small text-info'],
]); ?>

<p><?= Html::a('New Permission', ['create'], $viewOptions['button']) ?></p>
