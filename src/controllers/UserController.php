<?php

namespace app\controllers;

class UserController extends BaseWithAuthController
{
    /**
     * @SWG\Get(
     *   path="/user/change-info",
     *   tags={"用户信息"},
     *   summary="更新用户信息，JWT认证后操作",
     *   description="更新昵称，年龄等部分数据信息",
     *   produces={"application/xml", "application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="nickname",
     *     description="",
     *     required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="sex",
     *     description="",
     *     required=true,
     *     type="integer",
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="age",
     *     description="",
     *     required=true,
     *     type="integer",
     *   ),
     *
     *   @SWG\Response(response=200,description=""),
     * )
     *
     */
    public function actionChangeInfo(){
        $user =  $this->getLoginUser();
        //业务需要，只能更新这3个数字
        $user->nickname = $this->getParam('nickname');
        $user->sex = $this->getParam('sex');
        $user->age = $this->getParam('age');

        if($user->save()){
            return $this->succ($user);
        }
        throw new \Exception('更新用户信息失败');
    }
}
