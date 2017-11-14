<?php

use yii\db\Migration;

/**
 * Class m171104_055828_OperationTable
 */
class m171104_055829_OperationTable extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
         $this->createTable('{{%operations}}',[
            'id'             => $this->primaryKey()->comment('Первичный ключ'),
            'date'           => $this->dateTime()->notNull(),
            'summ'           => $this->double()->notNull(),
            'sender'         => $this->string()->notNull(),
            'recipient'      => $this->string()->notNull(),
            'name_creator'   => $this->string()->notNull(),
            'account_balance'=> $this->double()->notNull(),
        ]);
     //   $this->addForeignKey('FK_user_operations', '{{%operations}}', 'name_creator', '{{%users}}', 'username');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171104_055828_OperationTable cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171104_055828_OperationTable cannot be reverted.\n";

        return false;
    }
    */
}
