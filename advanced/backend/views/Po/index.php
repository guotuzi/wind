<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\models\PoItemSearch;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\PoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="po-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Po', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        // GridView 开始
        'columns' => [
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'value'=> function($model,$key,$index,$column){
                    return GridView::ROW_COLLAPSED;     // 将数据源中的一行数据，也就是一条记录，显示为在web页面上输出表格中的一行
                },
                'detail' => function($model,$key,$index,$column){
                    $searchModel = new PoItemSearch();
                    $searchModel->po_id = $model->id;
                    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                    return Yii::$app->controller->renderPartial('_poitems', [
                            //renderPartial 则不输出父模板的内容。只对本次渲染的局部内容，进行输出。
                            //render 输出父模板的内容，将渲染的内容，嵌入父模板。
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                    ]);
                }
            ],

            // GridView 结束
            'po_no',
            'description:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
