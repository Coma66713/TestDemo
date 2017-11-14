<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\Html;
use app\models\AccountModel;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class UserEditForm extends Model 
{
    public $username;
    public $email;
    public $password;
    public $access;
    public $id;
    /**
     * @inheritdoc
     */
    public function rules() 
    {
        return [
            ['username', 'trim'],
            ['username', 'email'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['password', 'string', 'min' => 6],
            ['access', 'string'],
        ];
    }

    /**
     * Registers user
     *
     * @return User|null the saved model or null if saving fails
     */
    public function edit($id) 
    {
        if (!$this->validate()) {
            return null;
        }
 
        $account = AccountModel::find()->where(['id'=>$id])->one();   
        $user = User::find()->where(['username' => $account->username])->one();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!empty($this->password) ){
                $user->password_hash = \Yii::$app->security->generatePasswordHash($this->password);
                $user->update();
            }  
            //здесь оставила обновление напрямую, так как модели для таблицы доступа нет.
            if(\Yii::$app->db->createCommand(
                    'UPDATE auth_assignment SET item_name = :add WHERE user_id = :id')
                ->bindValues([
                   'add' => $this->access,
                   'id' => $user->id,
                ])->queryAll()) {
               
                $transaction->commit();
                
                return 'tr ok';
            }
        } catch (\Throwable $e) {
              $transaction->rollBack();
        }
        
        return null;
    }

}

?>
