<?php

use yii\db\Migration;

/**
 * Class m171104_055737_UsersTable
 */
class m171104_055737_UsersTable extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id'            => $this->primaryKey()->comment('Первичный ключ'),
            'username'      => $this->string()->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'status'        => $this->integer()->notNull()->defaultValue(app\models\User::STATUS_ACTIVE),
            'activator'     => $this->string()->notNull()->unique(),
            'auth_key'      => $this->string()->notNull()->unique(),
            
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
       $this->dropTable('{{%users}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171104_055737_UsersTable cannot be reverted.\n";

        return false;
    }
    */
}
