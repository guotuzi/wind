<?php

namespace backend\components;

class checkIfLoggedIn extends \yii\base\Behavior
{
    // 如果要让行为响应对应组件的事件触发， 就应覆写 yii\base\Behavior::events() 方法
    // 判断用户是否登录
    public function events ()
    {
        return [
            \yii\web\Application::EVENT_BEFORE_REQUEST => 'checkIfLoggedIn',
        ];
    }

    public function checkIfLoggedIn(){
        if(\Yii::$app->user->isGuest)
        {
            echo "you are a Guest";
        }
    }

}


?>