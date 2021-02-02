<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user wsidebottom\pluto\models\User */
/* @var $link string */

?>
<div class="confirm-email">
    <p><?= 'Hello '.$user->username ?></p>

    <p><?= 'Follow the link below to verify your email:' ?></p>

    <p><?= Html::a(Html::encode($link), $link) ?></p>
</div>
