<?php
namespace service;

use app\models\User;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class UserService
{
    /**
     * 用户注册
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public static function userReg(User $user){
        if($user->save()){
            return true;
        }
        throw new \Exception('用户注册失败');
    }

    /**
     * 获取该账号用户
     * @param $account
     * @return User
     */
    public static function getUserByAccount($account){
        return User::findOne([
            'account' => $account
        ]);
    }

    /**
     * 该分配的JWT是否已经逻辑过期了
     * @param $md5Key
     * @return bool
     */
    public static function isJWTOutOfDate($md5Key){
        //return redis::has($md5Key) ? ture : false;
        return false;
    }

    /**
     * 将该JWT进行MD5后放入内存，比如REDIS,MEMCACHED
     * @param $md5Key
     * @param int $expireSecs
     * @return bool
     */
    public static function setJWTExpireTime($md5Key,$expireSecs=3600){
        //redis::set($md5Key,time() + $expireSecs);
        return true;
    }

    /**
     * 刷新该JWT的有效逻辑时间
     * @param $md5Key
     */
    public static function refreshJWTExpireTime($md5Key){
        self::setJWTExpireTime($md5Key);
    }

    /**
     * 根据JWT得到一个用户
     * @param $jsonWebToken
     * @return static
     * @throws \Exception
     */
    public static function getUserByJWT($jsonWebToken){
        try {
            $md5JWT = md5($jsonWebToken);
            $isOutOfDate = self::isJWTOutOfDate($md5JWT);
            if($isOutOfDate){
                return false;
            }

            /* @var $token \Lcobucci\JWT\Token */
            $token = \Yii::$app->jwt->getParser()->parse($jsonWebToken);

            if (!$token) {
                throw new \Exception('无效的JWT字符串' . __LINE__);
            }

            /* @var $data \Lcobucci\JWT\ValidationData */
            $data = \Yii::$app->jwt->getValidationData();
            if (!$token->validate($data)) {
                throw new \Exception('无效的JWT字符串' . __LINE__);
            }

            //获取到存放在TOKEN里面的用户编号
            $userid = $token->getClaim('uid');
            if ( ! $userid || ! is_numeric($userid) ) {
                throw new \Exception('无效的JWT字符串' . __LINE__);
            }

            $signer = new Sha256();
            if (!$token->verify($signer, $userid)) {
                throw new \Exception('无效的JWT字符串' . __LINE__);
            }

            self::refreshJWTExpireTime($md5JWT);

            return User::findOne($userid);
        }catch(\Exception $e){
            throw $e;
        }
    }

    /**
     * 生成一个JWT
     * @param User $loginUser
     * @return string
     */
    public static function createJWT(User $loginUser){
        $signer = new Sha256();
        $now = time();
        $expireTime = 3600;

        /* @var $builder \Lcobucci\JWT\Builder  */
        $builder = \Yii::$app->jwt->getBuilder();
        $token = $builder
        ->setId('jtwid'.$loginUser->id, true) // Configures the id (jti claim), replicating as a header item
        ->setIssuedAt($now) // Configures the time that the token was issue (iat claim)
        ->setNotBefore($now) // Configures the time before which the token cannot be accepted (nbf claim)
        ->setExpiration($now + $expireTime) // Configures the expiration time of the token (exp claim)
        ->set('uid', $loginUser->id) // Configures a new claim, called "uid"
        ->sign($signer, (string)($loginUser->id))
        ->getToken(); // Retrieves the generated token

        $tokenString = (string)$token;

        self::setJWTExpireTime(md5($tokenString), $expireTime);

        return $tokenString;
    }
}
