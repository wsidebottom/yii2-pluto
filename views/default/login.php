<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model wsidebottom\pluto\forms\LoginForm */
/* @var $context yii\web\Controller */
/* @var $form yii\widgets\ActiveForm */

$context = $this->context;
$module = $context->module;
$viewOptions = $module->viewOptions;
$pwHint = $module->passwordHint;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<?=Html::beginTag('div', $viewOptions['row'])?>
    <?=Html::beginTag('div', $viewOptions['col'])?>
        <h1><?=Html::encode($this->title)?></h1>
        <?php $form = $module->formClass::begin();?>
            <?=$form->field($model, 'username')->textInput(['autofocus' => true])?>
            <?=$this->render('_password', ['model' => $model, 'form' => $form, 'pwHint' => $pwHint])?>
            <?=$form->field($model, 'rememberMe')->checkbox()?>
            <?=$this->render('_captcha', ['model' => $model, 'form' => $form])?>
            <div class="form-group mt-4">
                <?=Html::submitButton('Login', $viewOptions['button'])?>
            </div>
        <?php $module->formClass::end();?>
        <hr />
        <p>
        <?php if (!$module->fenceMode): ?>
            <?=Html::a('Register', ['signup'], array_merge(['title' => 'If you\'re new here'], $viewOptions['link']))?>
        <?php endif;?>
            <?=Html::a('Forgot password', ['forgot'], array_merge(['title' => 'Reset your password'], $viewOptions['link']))?>
        <?php if (!$module->fenceMode): ?>
            <?=Html::a('Reconfirm', ['resend'], array_merge(['title' => 'Send me the email with confirmation instructions again'], $viewOptions['link']))?>
        <?php endif;?>
        </p>
    </div>
</div>
