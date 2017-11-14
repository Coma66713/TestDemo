<?php

use yii\db\Migration;

/**
 * Class m171104_081135_addInTables
 */
class m171104_081135_addInTables extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->insert('users', array(
            'username' => 'admin@mail.ru',
            'password_hash' => '$2y$13$ufZfb2NoqYMMcnjqJKhFiOd1KQag.BfJ6xqE64O6GGORJpGY1iZQ2',
            'status' => '1',
            'activator' => md5('admin@mail.ru'),
        ));
        $this->insert('users', array(
            'username' => 'visitor@mail.ru',
            'password_hash' => '$2y$13$ufZfb2NoqYMMcnjqJKhFiOd1KQag.BfJ6xqE64O6GGORJpGY1iZQ2',
            'status' => '1',
            'activator' =>md5('visitor@mail.ru'),
        ));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171104_081135_addInTables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171104_081135_addInTables cannot be reverted.\n";

        return false;
    }
    */
}
