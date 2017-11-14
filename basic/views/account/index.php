<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AccountSearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accounts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-model-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>

    </p>
    <?php if(Yii::$app->session->hasFlash('deposit_done')):?>
        <div class="alert alert-success">
            <?= Html::encode(Yii::$app->session->getFlash('deposit_done')) ?>
        </div>
    <?php elseif(Yii::$app->session->hasFlash('deposit_error')):?>
        <div class="alert alert-danger">
            <?= Html::encode(Yii::$app->session->getFlash('deposit_error')) ?>
        </div>
    <?php endif; ?>
    <?php if(Yii::$app->session->hasFlash('transfer_done')):?>
        <div class="alert alert-success">
            <?= Html::encode(Yii::$app->session->getFlash('transfer_done')) ?>
        </div>
    <?php elseif(Yii::$app->session->hasFlash('transfer_error')):?>
        <div class="alert alert-danger">
            <?= Html::encode(Yii::$app->session->getFlash('transfer_error')) ?>
        </div>
    <?php endif; ?>
    <?php if(Yii::$app->session->hasFlash('user_create_done')):?>
        <div class="alert alert-success">
            <?= Html::encode(Yii::$app->session->getFlash('user_create_done')) ?>
        </div>
    <?php endif; ?>
    <?php if(Yii::$app->session->hasFlash('user_create_error')):?>
        <div class="alert alert-danger">
            <?= Html::encode(Yii::$app->session->getFlash('user_create_error')) ?>
        </div>
    <?php endif; ?>
    <?php if(Yii::$app->session->hasFlash('user_edit_done')):?>
        <div class="alert alert-success">
            <?= Html::encode(Yii::$app->session->getFlash('user_edit_done')) ?>
        </div>
    <?php elseif(Yii::$app->session->hasFlash('user_edit_error')):?>
        <div class="alert alert-danger">
            <?= Html::encode(Yii::$app->session->getFlash('user_edit_error')) ?>
        </div>
    <?php endif; ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'style' => 'width: 500px;',
        ], 
        'columns' => [
            'username',
            'summ',
            ['class' => 'yii\grid\ActionColumn',
                'template' => ' {view} {deposit_to_an_account} {money_transfer}',
                'buttons' => [
                    'deposit_to_an_account' => function ($url) {
                        return Html::a('Зачислить', $url);
                    },
                    'money_transfer' => function ($url) {
                        return Html::a('Отправить', $url);
                    },
                ],
            ],
        ],
    ]);
    ?>
</div>
