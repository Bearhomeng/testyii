<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>
    
    <p>
    	如果您有任何疑问，请<?= Html::a('联系我们',Yii::$app->homeUrl.'?r=site/contact') ?>。非常感谢！
    </p>

</div>
