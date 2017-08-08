<?php
namespace app\models;
use Yii;

// implements IdentityInterface
trait UserTrait{
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentity() method.
    }

    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.
    }

    public function getId()
    {
        // TODO: Implement getId() method.
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
}
