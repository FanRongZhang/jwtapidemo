<?php

use yii\db\Migration;

class m170808_055549_user extends Migration
{
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'account' => $this->char(30)->comment('账号')->notNull(),
            'hash' => $this->char(60)->comment('密码hash')->notNull(),
            'nickname' => $this->char(20)->defaultValue('')->comment('昵称')->notNull(),
            'sex' => $this->integer()->comment('性别')->defaultValue(1)->notNull(),
            'age' =>  $this->integer()->comment('年龄')->defaultValue(0)->notNull(),
            'create_date' =>$this->date()->comment('注册日期')->notNull(),
            'create_time' =>$this->integer()->comment('注册时间')->notNull(),
        ],'AUTO_INCREMENT=1000');

        $this->addCommentOnTable('user', '用户');
    }

    public function safeDown()
    {
        echo "m170808_055549_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170808_055549_user cannot be reverted.\n";

        return false;
    }
    */
}
