<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AccountModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="account-model-form">

    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-2\">{input}</div>\n<div class=\"col-lg-10\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg- control-label'],
            ],
    ]); ?>

    <?= $form->field($model, 'summ')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Зачислить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
