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
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel wsidebottom\pluto\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $defaultRoles string[] */
/* @var $context yii\web\Controller */

$context = $this->context;
$viewOptions = $context->module->viewOptions;

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss('
.filters .form-control {
    font-size: .875em;
    padding: .1rem .5rem;
    height: 2em;
}');
?>

<p><?=Html::a('New User', ['create'], $viewOptions['button'])?>
<?php if (Yii::$app->user->can('manageRoles')): ?>
    <?=Html::a('Roles', ['role/index'], $viewOptions['link'])?>
<?php endif;?></p>

<?=GridView::widget([
    'id' => 'users-grid',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
    'filterRowOptions' => ['class' => 'kartik-sheet-style'],
    'pjax' => true,
    'toolbar' => [
        ['content' => Html::a('<i class="fas fa-redo"></i>', ['farm-reset'], ['class' => 'btn btn-outline-secondary', 'title'=> 'Reset Grid', 'data-pjax' => 1])],
        '{export}',
        '{toggleData}'
    ],
    'columns' => [
        //['class' => 'kartik\grid\SerialColumn'],
        [
            'attribute' => 'username',
            'content' => function ($model, $key, $index, $widget) {
                return Yii::$app->user->can('updateUser', $model) ? Html::a($model->username, ['update', 'id' => $model->id]) : $model->username;
            },
            'format' => 'html',
        ],
        'email:email',
        'statusText',
        'singleRole',
        'created_at',
        'updated_at',
        [
            'attribute' => 'lastlogin_at',
            'headerOptions' => ['class' => 'sort-ordinal'],
        ],
        [
            'attribute' => 'login_count',
            'headerOptions' => ['class' => 'sort-numerical'],
        ],
        [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{update}', // {delete}',
            'visibleButtons' => [
                //'delete' => function ($model, $key, $index) {
                //    return Yii::$app->user->can('updateUser', $model) && Yii::$app->user->id != $model->id; // user can't delete themself
                //},
                'update' => function ($model, $key, $index) {
                    return Yii::$app->user->can('updateUser', $model);
                },
            ],
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
    'emptyTextOptions' => ['class' => 'small text-info'],
    'toggleDataContainer' => ['class' => 'btn-group mr-2'],
    'export' => ['fontAwesome' => true],
    'bordered' => true,
    'striped' => true,
    'condensed' => true,
    'responsive' => true,
    'hover' => true,
    'showPageSummary' => false,
    'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<span class="fas fa-book"></span>  ' . Html::encode($this->title),
    ],
    'persistResize' => false,
    'toggleDataOptions' => ['minCount' => 10],
    'itemLabelSingle' => 'user',
    'itemLabelPlural' => 'users'
]);?>

<?php if (!empty($defaultRoles)): ?>
    <p><strong>Default Roles: </strong><?=implode(', ', $defaultRoles)?></p>
<?php endif;?>
