<?php

use yii\db\Migration;

/**
 * Class m171104_080028_addRoles
 */
class m171104_081136_addRoles extends Migration
{
    /**
     * @inheritdoc
     */
        public function safeUp()
    {
        $rbac = \Yii::$app->authManager;
        
        $guest = $rbac->createRole('guest');
        $guest->description = 'Гость';
        $rbac->add($guest);
        
        $visitor = $rbac->createRole('visitor');
        $visitor->description = 'Посетитель';
        $rbac->add($visitor);
        
        $admin = $rbac->createRole('admin');
        $admin->description = 'Управление сайтом';
        $rbac->add($admin);
        
        $rbac->addChild($admin, $visitor);
        $rbac->addChild($visitor, $guest);
        
        $rbac->assign(
                $visitor, 
                \app\models\User::findOne([
                    'username'=> 'visitor@mail.ru'])->id
        );
        $rbac->assign(
                $admin, 
                \app\models\User::findOne([
                    'username'=> 'admin@mail.ru'])->id
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $manager = \Yii::$app->authManager;
        $manager->removeAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171104_080028_addRoles cannot be reverted.\n";

        return false;
    }
    */
}
