<?php

namespace app\controllers;

use app\models\User;
use service\UserService;
use yii\rest\ActiveController;

/**
 * 用户账号接口
 * @package app\controllers
 */
class AccountController extends BaseController
{
    /**
     * @SWG\GET(
     *   path="/account/reg",
     *   tags={"账号"},
     *   summary="新用户注册",
     *   description="注册新账号",
     *   produces={"application/xml", "application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="account",
     *     description="",
     *     required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="password",
     *     description="",
     *     required=true,
     *     type="string",
     *   ),
     *
     *   @SWG\Response(response=200,description=""),
     * )
     *
     */
    public function actionReg(){
        $account = $this->getParam('account');
        $password = $this->getParam('password');

        if(!$account || !$password){
            return $this->fail(20);
        }

        $user = UserService::getUserByAccount($account);
        if($user){
            return $this->fail(20);
        }

        $user = new User();
        $user->account = $account;
        $user->hash = \Yii::$app->getSecurity()->generatePasswordHash($password);
        $user->nickname = 'nk-' . date('mHis');
        $user->sex = 1;
        $user->age = 18;
        $user->create_date = date('Y-m-d');
        $user->create_time = time();

        if(UserService::userReg($user)){
            return $this->succ($user);
        }

        throw new \Exception('注册失败');

    }

    /**
     * @SWG\Get(
     *   path="/account/login",
     *   tags={"账号"},
     *   summary="jwt的获取",
     *   description="登录后返回json web token给请求方",
     *   produces={"application/xml", "application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="account",
     *     description="",
     *     required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="password",
     *     description="",
     *     required=true,
     *     type="string",
     *   ),
     *
     *   @SWG\Response(response=200,description=""),
     * )
     *
     */
    public function actionLogin(){
        $account = $this->getParam('account');
        $password = $this->getParam('password');

        if( ! $account || ! $password ){
            return $this->fail(20);
        }

        $user = UserService::getUserByAccount($account);
        if($user && \Yii::$app->getSecurity()->validatePassword($password, $user->hash)){
            return $this->succ([
                'token' => UserService::createJWT($user)
            ]);
        }
        return $this->fail(20);
    }
}
