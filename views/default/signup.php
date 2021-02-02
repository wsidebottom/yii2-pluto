<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model wsidebottom\pluto\models\User */
/* @var $context yii\web\Controller */
/* @var $form yii\widgets\ActiveForm */

$context = $this->context;
$module = $context->module;
$viewOptions = $module->viewOptions;
$pwHint = $context->module->passwordHint;

$this->title = Yii::t('pluto', 'Register');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Html::beginTag('div', $viewOptions['row']) ?>
    <?= Html::beginTag('div', $viewOptions['col']) ?>
        <h1><?= Html::encode($this->title) ?></h1>
        <p class="hint-block"><?= 'Please fill out these fields to register at '.Yii::$app->name ?>.</p>
        <?php $form = $module->formClass::begin(); ?>
        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'maxlength' => true, 'placeholder' => 'Username']) ?>
            <?= $form->field($model, 'firstname')->textInput(['maxlength' => true, 'placeholder' => 'Given Name']) ?>
            <?= $form->field($model, 'lastname')->textInput(['maxlength' => true, 'placeholder' => 'Surname']) ?>
            <?= $form->field($model, 'email')->hint('This must be a real email address')->textInput(['maxlength' => true, 'placeholder' => 'address@example.com']) ?>
            <?= $this->render('_password', ['model' => $model, 'form' => $form, 'pwHint'=>$pwHint]) ?>
            <?= $this->render('_captcha', ['model' => $model, 'form' => $form]) ?>
            <div class="form-group mt-4">
                <?= Html::submitButton('Register', $viewOptions['button']) ?>
            </div>
        <?php $module->formClass::end(); ?>
    </div>
</div>
