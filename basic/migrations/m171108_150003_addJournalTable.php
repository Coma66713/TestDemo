<?php

use yii\db\Migration;

/**
 * Class m171108_150003_addJournalTable
 */
class m171108_150003_addJournalTable extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%journal}}', [
            'id'          => $this->primaryKey()->comment('Первичный ключ'),
            'id_account'  => $this->integer()->notNull(),
            'id_operation'=> $this->integer()->notNull(),
        ]);
        $this->addForeignKey('FK_journal_account', '{{%journal}}', 'id_account', '{{%account}}', 'id');  
        $this->addForeignKey('FK_journal_operation', '{{%journal}}', 'id_operation', '{{%operations}}', 'id'); 
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
         $this->dropTable('{{%journal}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171108_150003_addJournalTable cannot be reverted.\n";

        return false;
    }
    */
}
