<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="languages" ">
        <?php
            foreach(Yii::$app->params['languages'] as $key => $language ){
                echo '<span class="language" id="' . $key . '">'. $language . ' | </span>';
            }
        ?>
    </div>

    <div class="jumbotron">
        <h1>Fuck!</h1>

        <p class="lead"><?= Yii::t('app', 'Welcome'); ?> to HELL</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

    </div>
</div>
