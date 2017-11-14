<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AccountModel */

$this->title = 'Transfer money';
if(Yii::$app->user->can('admin')) {
    $this->params['breadcrumbs'][] = ['label' => 'Accounts', 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
} else $this->params['breadcrumbs'][] = ['label' => 'Account', 'url' => ['user_index']];

$this->params['breadcrumbs'][] = 'Transfer';
?>
<div class="account-model-update">
    
    <?php if(Yii::$app->session->hasFlash('transfer_error')):?>
        <div class="alert alert-danger">
            <?= Html::encode(Yii::$app->session->getFlash('transfer_error')) ?>
        </div>
    <?php endif; ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_transfer_form', [
        'model' => $model,
    ]) ?>

</div>