<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AccountSearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Account Models';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-model-index">
    
    <?php if(Yii::$app->session->hasFlash('transfer_done')):?>
        <div class="alert alert-success">
            <?= Html::encode(Yii::$app->session->getFlash('transfer_done')) ?>
        </div>
    <?php elseif(Yii::$app->session->hasFlash('transfer_error')):?>
        <div class="alert alert-danger">
            <?= Html::encode(Yii::$app->session->getFlash('transfer_error')) ?>
        </div>
    <?php endif; ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'style' => 'width: 500px;',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],   
                'summ',
                'username',
            ['class' => 'yii\grid\ActionColumn',
                'template' => ' {deposit_to_an_account} {money_transfer}',
                'buttons' => [
                    'money_transfer' => function ($url) {
                        return Html::a('Отправить', $url);
                    },
                ],
            ],
        ],
    ]);
    ?>
</div>
