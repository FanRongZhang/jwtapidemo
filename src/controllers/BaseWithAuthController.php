<?php

namespace app\controllers;

use app\models\User;
use service\UserService;
use sizeg\jwt\JwtHttpBearerAuth;

class BaseWithAuthController extends BaseController
{
    /**
     * 当前通过token认证的用户
     * @return User
     */
    public function getLoginUser(){
        return \Yii::$app->user->identity;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => JwtHttpBearerAuth::className(),
            'auth' => function($token, $authMethod) {
                return UserService::getUserByJWT($token);
            }
        ];
        return $behaviors;
    }
}
