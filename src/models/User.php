<?php
namespace app\models;
use Yii;
/**
* 代码自动生成 user-用户表的模型类 
* @property integer $id   
* @property string $account   账号
* @property string $hash   密码hash
* @property string $nickname   昵称
* @property integer $sex   性别
* @property integer $age   年龄
* @property date $create_date   注册日期
* @property integer $create_time   注册时间
*/
class User extends \yii\db\ActiveRecord
{
      use UserTrait;
     public static function tableName(){
         return 'user';
     }
}
