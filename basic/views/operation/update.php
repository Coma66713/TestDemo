<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OperationModel */

$this->title = 'Update Operation Model: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Operation Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="operation-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>