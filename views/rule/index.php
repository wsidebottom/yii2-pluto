<?php
/**
 * yii2-pluto
 * ----------
 * User management module for Yii2 framework
 * Version 1.0.0
 * Copyright (c) 2019
 * Sjaak Priester, Amsterdam
 * MIT License
 * https://github.com/wsidebottom/yii2-pluto
 */

use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $regData yii\data\BaseDataProvider */
/* @var $unregData yii\data\BaseDataProvider */
/* @var $context yii\web\Controller */

$context = $this->context;
$viewOptions = $context->module->viewOptions;
$buttonOptions = $viewOptions['button'];
$buttonOptions['data-method'] = 'post';

$gridOptions = [
    'formatter' => [
        'class' => 'yii\i18n\Formatter',
        'datetimeFormat' => 'short', // 'dd-MM-yyyy HH:mm:ss'
        'nullDisplay' => '',
    ],
    'tableOptions' => ['class' => 'table table-sm table-bordered'],
    'summary' => '<div class="small text-info">{begin}-{end}/{totalCount}</div>',
    'emptyText' => 'none',
    'emptyTextOptions' => ['class' => 'small text-info'],
];

$this->title = 'Conditions';
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['role/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?=$this->title?></h1>

<?=GridView::widget(array_merge($gridOptions, [
    'dataProvider' => $regData,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
            'contentOptions' => ['class' => 'text-info'],
        ],
        'name',
        [
            'label' => 'Class',
            'content' => function ($model, $key, $index, $widget) {
                return get_class($model);
            },

        ],
        'createdAt:datetime',
        'updatedAt:datetime',

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
        ],
    ],
]));?>

<?php if ($unregData->totalCount > 0): ?>

<fieldset class="mt-5">
    <legend><?='Unregistered Conditions'?></legend>

    <?=GridView::widget(array_merge($gridOptions, [
    'dataProvider' => $unregData,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
            'contentOptions' => ['class' => 'text-info'],
        ],
        'name',
        [
            'label' => 'Classname',
            'content' => function ($model, $key, $index, $widget) {
                return get_class($model);
            },

        ],
    ],
]));?>

    <div class="form-group">
        <?=Html::a('Register', ['index'], $buttonOptions)?>
    </div>
</fieldset>

<?php endif;?>