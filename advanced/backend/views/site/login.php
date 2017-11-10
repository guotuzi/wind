<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="login-box">
        <div class="login-logo">
            <a href="../../index2.html"><b>Admin</b>LTE</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'username',
                    ['options' => [
                        'tag' => 'div',      //如何添加 div 标签
                        'class' => 'form-group has-feedback',
                        ],
                        'template' => '{input}<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                      {error}{hint}'      //如何添加 input 标签
                ] )->textInput(['placeholder' => 'Username']) ?>     <!--如何添加 placeholder 元素-->


                <?= $form->field($model, 'password',
                    ['options' => [
                        'tag' => 'div',
                        'class' => 'form-group has-feedback',
                    ],
                        'template' => '{input}<span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                        {error}{hint}'
                        ]
                    )->passwordInput(['placeholder' => 'Password']) ?>


            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox"> Remember Me
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
                <!-- /.col -->
            </div>



            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>






