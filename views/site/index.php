<?php
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <p><a class="btn btn-lg btn-success" href="<?= Url::to(['order/index'])?>">Go to orders page</a></p>
    </div>
\
</div>
