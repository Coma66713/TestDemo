<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Operation Models';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="operation-model-index">

    <h1><?= Html::encode($this->title) ?></h1>

   <?php Pjax::begin();?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            
            ['class' => 'yii\grid\SerialColumn'],
            'date',
            'summ',
            'sender',
            'recipient',
            'name_creator',
            'account_balance',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => ' ',
            ],
       ],
    ]); ?>
    <?php Pjax::end();?>
</div>
