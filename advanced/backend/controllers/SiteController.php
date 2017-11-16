<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    //允许认证用户
                    [
                        'actions' => ['login', 'error', 'language'],   //权限啊，权限啊！！！
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'set-cookie', 'show-cookie'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // 默认禁止其他用户
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],    // 只允许 post 方式访问
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    /**
     * 设置cookie
     */
public function actionSetCookie(){
    $cookie = new yii\web\Cookie([
        'name' => 'test',
        'value' => 'test cookie value'
    ]);
    Yii::$app->getResponse()->getCookies()->add($cookie);
}

public function actionShowCookie(){
    if(Yii::$app->getRequest()->getCookies()->has('test')){
        print_r(Yii::$app->getRequest()->getCookies()->getValue('test'));
    }
}


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        /*
        //试用自己创建的 component
        Yii::$app->MyComponent->hello();
        die();
        echo Yii::$app->MyComponent->currencyConvert('USD','RMB', 100);
        die(); */
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        // 指定自己创建的 layout
        $this->layout = 'loginLayout';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    //多语言
    public function actionLanguage(){
        if(isset($_POST['lang'])){
            Yii::$app->language = $_POST['lang'];
            $cookie = new yii\web\Cookie([
                'name' => 'lang',
                'value' => $_POST['lang'],
            ]);
            Yii::$app->getResponse()->getCookies()->add($cookie);
        }
    }



}
