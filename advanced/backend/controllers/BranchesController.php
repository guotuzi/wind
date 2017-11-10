<?php

namespace backend\controllers;

use kartik\form\ActiveForm;
use Yii;
use backend\models\Branches;
use backend\models\BranchesSearch;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * BranchesController implements the CRUD actions for Branches model.
 */
class BranchesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Branches models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BranchesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // 使用 yii2-editable 扩展开始
        if(Yii::$app->request->post('hasEditable')){
            $branchId = Yii::$app->request->post('editableKey');
            $branch = Branches::findOne($branchId);

            $out = Json::encode(['output'=>'', 'message'=>'']);    //将数据以json 格式输出
            $post = [];
            $posted = current($_POST['Branches']);     // current — 返回数组中的当前单元
            $post ['Branches'] = $posted;
            if($branch->load($post))     // load 加载数据， validate根据rules进行校验, save 的时候会自动调用 validate, 没写rules 就不能 load， 至少也得是safe
            {
                $branch->save();     // 保存收到的修改数据
                $output = 'my value';  //修改后，还没刷新的时候显示 my value 字样；
                $out = Json::encode(['output'=>$output, 'message'=>'']);
            }
            echo $out;
            return;

        }
        // 使用 yii2-editable 扩展结束

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * 下载PHPExcel 扩展
     * yii2 上传 Excel 表格
     */
    public function actionImportExcel()
    {
        $inputFile = 'Uploads/branche_file.xlsx';
        try{
            $inputFileType = \PHPExcel_IOFactory::identify($inputFile);   //这个斜杠不能丢，表示去外部找扩展的意思
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFile);

        } catch (Exception $e){
            die( 'Error' );
        }
        $sheet = $objPHPExcel->getSheet(0);
        $hightestRow = $sheet->getHighestRow();
        //print_r($hightestRow); exit;
        $hightestColumn = $sheet->getHighestColumn();

        for( $row=1; $row <= $hightestRow; $row++ ){
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $hightestColumn . $row, NULL, TRUE, FALSE);

            if($row == 1){
                continue;
            }
            $branch = new Branches();
            $branch->branch_id = $rowData[0][0];
            $branch-> companies_company_id = $rowData[0][1]	;
            $branch-> 	branch_name = $rowData[0][2];
            $branch-> 	branch_address = $rowData[0][3];
            $branch-> branch_created_date = date('Y-m-d H:i:s');
            $branch-> branch_status = $rowData[0][4];
            $branch->save();
        }
        die('OK');
    }



    /**
     * Displays a single Branches model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Branches model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        // 配置权限，RBAC
        if( Yii::$app->user->can( 'create-branch') )
        {
            $model = new Branches();

            if ($model->load(Yii::$app->request->post())) {
                $model->branch_created_date = date('Y-m-d H:m:s');    //添加日期
                $model->save();
                return $this->redirect(['view', 'id' => $model->branch_id]);
            } else {
                return $this->renderAjax('create', [
                    'model' => $model,
                ]);
            }
        } else
            {
                throw new ForbiddenHttpException;
            }
    }

    /**
     * create 页面 branch_name 的ajax 验证
     */
    public function actionValidation(){
        $model = new Branches();

        // ajax 验证
        if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))
        {
            Yii::$app->response->format = 'json';
            return ActiveForm::validate($model);
        }
    }




    /**
     * Updates an existing Branches model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->branch_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Branches model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }



    /**
     * departments create 页面的 联动下拉菜单
     * @param $id    : departments 表单jquery ajax 传过来的id
     */
    public function actionLists($id){
        $countBranches = Branches::find()
            ->where(['companies_company_id' => $id])
            ->count();

        $branches = Branches::find()
            ->where(['companies_company_id' => $id])
            ->all();

        if($countBranches>0){
            foreach ($branches as $branch){
                echo "<option value=" . $branch->branch_id . "'>" . $branch->branch_name . "</potion>";
            }
        } else {
            echo "<option>-</option>";
        }
    }



    /**
     * Finds the Branches model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Branches the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Branches::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
