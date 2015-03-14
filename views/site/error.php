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
       	十分抱歉！在处理您的请求时，服务器出现了以上的问题。
    </p>
    <p>
        	如果您觉得是我们的服务器存在问题，请联系我们。非常感谢！
    </p>

</div>
