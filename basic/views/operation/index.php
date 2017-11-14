<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OperationSearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Operation Models';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="operation-model-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   
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
                'template' => '',
                    
            ],
       ],
    ]); ?>
   
</div>
