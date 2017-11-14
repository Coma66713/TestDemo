<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OperationSearchModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="operation-model-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'summ') ?>

    <?= $form->field($model, 'sender') ?>

    <?= $form->field($model, 'recipient') ?>

    <?php // echo $form->field($model, 'id_creator') ?>

    <?php // echo $form->field($model, 'account_balance') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
