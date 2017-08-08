<?php

namespace app\controllers;

use Swagger\Annotations\Swagger;
use yii\rest\Controller;

/**
 * API UI
 * @package app\controllers
 */
class ApidocController extends Controller
{
    public function actionIndex(){
        return \Swagger\scan(__DIR__.'/');
    }
}
