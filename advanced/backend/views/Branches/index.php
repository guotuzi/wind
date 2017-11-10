<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;     //使用 pop up 弹出框的
use yii\helpers\Url;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BranchesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Branches';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="branches-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <!--Pop up 弹出层效果开始(还要在asset 中配置，js 文件在 web->js->main.js)
    <!--    创建一个按钮，用于调modal的显示-->
    <p>
        <?= Html::button('Create Branches', [
            'value'=>Url::to('index.php?r=branches/create'),
            'class' => 'btn btn-success',
            'id'=>'modalButton'])
        ?>
    </p>

    <!--创建modal-->
    <?php
    Modal::begin([
        'header' => '<h4>Branches</h4>',
        'id' => 'modal',
        'size' => 'modal-lg',    //这是大号的意思，可以写小号（-sm）
    ]);
    echo "<div id='modalContent'></div>";
    Modal::end();
    ?>
    <!--Pop up 弹出层效果结束    -->



    <!-- 使用 yii2-export 开始-->
    <?php
    $gridColumns = [
//        ['class' => 'yii\grid\SerialColumn'],
        'branch_name',
        'branch_address',
        'branch_created_date',
        'branch_status',
//        ['class' => 'yii\grid\ActionColumn'],
    ];

    // Renders a export dropdown menu
    echo ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns
    ]);

    ?>
    <!-- 使用 yii2-export 结束-->


    <!-- 使用 Pjax 开始-->
<!-- 使用Pjax 指的是整个页面不用刷新，就进行了搜索，燕十八说：pjax 并不是解决 ajax 跨页面的问题，他没有用到XHR-->
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => false,
//        'Pjax' => true,

        // 添加背景色开始
        'rowOptions'=>function($model){
            if($model-> branch_status == 'inactive')
            {
                return ['class' => 'danger'];
            } else
            {
                return ['class' => 'success'];
            }
        },
        // 添加背景色结束

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                    'attribute'=> 'companies_company_id',   //添加搜索框
                    'value' => 'companiesCompany.company_name',
            ],

            // 使用 yii2-editable 开始
            [
                    'class' => 'kartik\grid\EditableColumn',
                    'header' => 'Branch Name',
                    'attribute' => 'branch_name',
                    'value' => function($model){
                            return $model->branch_name;
                    }
            ],
            // 使用 yii2-editable 结束

            'branch_address',
            'branch_created_date',
            'branch_status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
    <!-- 使用 Pjax 结束-->
</div>
