<?php
use yii\helpers\Html;

$this->title = 'Подписка';
$this->registerMetaTag([
    'name' => 'robots',
    'content' => 'noindex,nofollow'
]);

$this->params['breadcrumbs'][] = $this->title;
?>

  <h1><?= Html::encode($this->title) ?></h1>
    <div class="top_block white">
        <div class="content">
            <?=$text?>
        </div>
    </div>    