<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\JournalModel */

$this->title = 'Create Journal Model';
$this->params['breadcrumbs'][] = ['label' => 'Journal Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="journal-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
