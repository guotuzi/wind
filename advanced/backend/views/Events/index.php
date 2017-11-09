<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EventsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="events-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Events', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <!--使用fullCalender 开始， 代替原来的表格（ GridView::widget）-->

    <?= yii2fullcalendar\yii2fullcalendar::widget(array(
            'events' => $events,
    ));
        ?>
    <!--使用fullCalender 结束-->
</div>
