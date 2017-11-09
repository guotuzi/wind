<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;     //使用 pop up 弹出框的

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EventsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="events-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!--创建modal-->
    <?php
    Modal::begin([
        'header' => '<h4>Events</h4>',
        'id' => 'modal',
        'size' => 'modal-lg',    //这是大号的意思，可以写小号（-sm）
    ]);
    echo "<div id='modalContent'></div>";
    Modal::end();
    ?>
    <!--Pop up 弹出层效果结束    -->



    <!--使用fullCalender 开始， 代替原来的表格（ GridView::widget）-->

    <?= yii2fullcalendar\yii2fullcalendar::widget(array(
            'events' => $events,
    ));
        ?>
    <!--使用fullCalender 结束-->
</div>
