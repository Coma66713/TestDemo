<?php

use yii\db\Migration;

/**
 * Class m171104_060006_AccountTable
 */
class m171104_060007_AccountTable extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%account}}',[
            'id'            => $this->primaryKey()->comment('Первичный ключ'),
            'summ'          => $this->double(),
            'username'      => $this->string()->notNull(),
        ]);
        $this->addForeignKey('FK_user_account', '{{%account}}', 'username', '{{%users}}', 'username');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%account}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171104_060006_AccountTable cannot be reverted.\n";

        return false;
    }
    */
}
