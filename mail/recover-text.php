<?php

/* @var $this yii\web\View */
/* @var $user wsidebottom\pluto\models\User */
/* @var $link string */

?>
<?= Yii::t('pluto', 'Hello {username},', [
    'username' => $user->name
]) ?>

<?= Yii::t('pluto', 'Follow the link below to reset your password:') ?>

<?= $link ?>
