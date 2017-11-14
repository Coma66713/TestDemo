<?php
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AccountModel */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Account Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="account-model-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['user/update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php Pjax::begin();?>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'summ',
                'username',
            ],
        ]) ?>
   
        <?= GridView::widget([
           'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
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
