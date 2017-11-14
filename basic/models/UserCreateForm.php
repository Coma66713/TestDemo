<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\Html;
use app\models\AccountModel;
use app\models\OperationModel;
use app\models\JournalModel;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class UserCreateForm extends Model 
{
    public $username;
    public $email;
    public $password;
    public $access;

    /**
     * @inheritdoc
     */
    public function rules() 
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'email'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['access', 'string'],
            ['access', 'required'],
        ];
    }

    /**
     * Create users
     *
     * @return User|null the saved model or null if saving fails
     */
    public function create() 
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->setPassword($this->password);
        $user->status = 1;

        $account = new AccountModel();
        $account->summ = 0;

        $operation = new OperationModel();
        $operation->date = new \DateTime();
        $operation->date = $operation->date->format(\DateTime::W3C);
        $operation->summ = 0;
        $operation->sender = '-@mail.ru';
        $operation->recipient = $this->username;
        $operation->name_creator = 'admin@mail.ru';
        $operation->account_balance = 0;

        $journal = new JournalModel();

        $email = Html::encode($this->username);
        $user->activator = md5($email . time());
        //отправка письма для подтверждения email
        //$user->generateAuthKey();
        $rbac = \Yii::$app->authManager;
        $accessRole = $rbac->getRole($this->access);

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($user->save()) {
                $account->username = $user->username;
                $rbac->assign($accessRole, $user->id);
                if ($account->save()) {
                    if ($operation->save()) {
                        
                        $journal->id_account = $account->id;
                        $journal->id_operation = $operation->id;
                        $journal->save();

                        $transaction->commit();
                    }
                    return $user;
                }
            }
        } catch (\Throwable $e) {
            $transaction->rollBack();
        }
        return null;
    }

}

?>
