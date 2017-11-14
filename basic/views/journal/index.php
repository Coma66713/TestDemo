<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\JournalSearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Journal Models';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="journal-model-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Journal Model', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_account',
            'id_operation',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
