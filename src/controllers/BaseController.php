<?php

namespace app\controllers;

use yii\helpers\ArrayHelper;
use yii\helpers\FormatConverter;
use yii\rest\ActiveController;

/**
 * 基类
 * @package app\controllers
 */
class BaseController extends ActiveController
{
    public $modelClass = 'app\models\User';

    public function actions()
    {
        $actions = parent::actions();

        // 禁用"delete" 和 "create" 动作
        unset($actions['delete'], $actions['create'] , $actions['update']);
        return $actions;
    }

    /**
     * 返回给客户端
     * 仅仅只是作为DEMO，未建立CODE和MSG之间的MAP服务
     * 这里粗凑的处理为0表示业务成功，非0未成功
     * @param $code
     * @param array $data
     * @return array
     */
    private function responseTo($code,$data=[]){
        \Yii::$app->response->format = \yii\web\response::FORMAT_JSON;
        $msg = $code==0 ? '' : 'some thing is wrong';
        return [
            'code' => $code,
            'data' => $data,
            'msg' => $msg
        ];
    }

    public function fail($code){
        return $this->responseTo('50x');
    }

    public function succ($data){
        return $this->responseTo(0,$data);
    }

    /**
     * 获取到请求的参数
     * @param $name
     * @return array|bool
     */
    public function getParam($name){
        $params = ArrayHelper::merge($_GET,$_POST);
        $newParams = [];
        if($params){
            foreach($params as $k=>$v){
                $newParams[strtolower($k)] = $v;
            }
        }
        $params = $newParams;

        if(!$name){
            return $params;
        }
        $name = strtolower($name);
        return isset($params[$name]) ? $params[$name] : false;
    }

}
