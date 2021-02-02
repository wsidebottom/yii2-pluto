<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user wsidebottom\pluto\models\User */
/* @var $link string */

?>
<div class="recover-email">
    <p><?= 'Hello '.$user->username ?></p>

    <p><?= 'Follow the link below to reset your password:' ?></p>

    <p><?= Html::a(Html::encode($link), $link) ?></p>
</div>
