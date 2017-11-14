<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AccountModel */

$this->title = 'Create Account Model';
$this->params['breadcrumbs'][] = ['label' => 'Account Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('create_user', [
        'model' => $model,
    ]) ?>

</div>d
