<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AccountModel */

$this->title = 'Deposit to an account';
$this->params['breadcrumbs'][] = ['label' => 'Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Deposit';
?>
<div class="account-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_deposit_form', [
        'model' => $model,
    ]) ?>

</div>