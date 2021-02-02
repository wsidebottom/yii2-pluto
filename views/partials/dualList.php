<?php
use softark\duallistbox\DualListbox;
use wsidebottom\pluto\assets\PlutoAsset;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model yii\base\Model */
/* @var $attribute string */
/* @var $items string[] */

/* @link https://github.com/softark/yii2-dual-listbox */

PlutoAsset::register($this);
?>
<fieldset class="mb-3">
    <legend><?= $model->getAttributeLabel($attribute) ?></legend>
<?= $form->field($model, $attribute, [
    'template' => "{input}\n{hint}\n{error}",
    'hintOptions' => ['class' => 'form-text text-muted text-right']
])->widget(DualListbox::class, [
    'items' => $items,
    'options' => [
        'multiple' => true,
        'size' => 8
    ],
    'clientOptions' => [
        'moveOnSelect' => false,
        'btnClass' => 'btn-sm btn-outline-secondary font-weight-bold',
        'nonSelectedListLabel' => 'Available',
        'selectedListLabel' => 'Selected',
        'filterTextClear' => 'Show all',
        'filterPlaceHolder' => 'Filter',
        'moveSelectedLabel' => 'Move selected',
        'moveAllLabel' => 'Move all',
        'removeSelectedLabel' => 'Remove selected',
        'removeAllLabel' => 'Remove all',
        'infoText' => "Showing all {0}",
        'infoTextFiltered' => "<span class='text-dark bg-warning'>Filtered</span> {0} from {1}",
        'infoTextEmpty' => 'Empty list',
        'btnMoveText' => '&rsaquo;',
        'btnRemoveText' => '&lsaquo;',
        'btnMoveAllText' => '&raquo;',
        'btnRemoveAllText'=> '&laquo;'
    ],
]) ?>
</fieldset>
