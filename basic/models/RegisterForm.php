<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\Html;

use app\models\AccountModel;
//use yii\behaviors\TimestampBehavior;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class RegisterForm extends Model
{
    public $username;
    public $email;
    public $password;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'email'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 
                'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }
    
    public static function mail_subscription_activation ($email, $cod)
    {

        $absoluteHomeUrl = 'http://localhost:8000/site'; //http://ваш сайт
        $serverName = Yii::$app->request->serverName; //ваш сайт без http
        $url = $absoluteHomeUrl.'activation/'.$cod;

        $msg = "Здравствуйте! Спасибо за регистрацию на сайте $serverName!  
            Вам осталось только подтвердить свой e-mail. Для этого перейдите по ссылке $url";

        $msg_html  = "<html><body style='font-family:Arial,sans-serif;'>";
        $msg_html .= "<h2 style='font-weight:bold;border-bottom:1px dotted #ccc;'>
            Здравствуйте! Спасибо за регистрацию  на сайте <a href='". $absoluteHomeUrl ."'>$serverName</a></h2>\r\n";
        $msg_html .= "<p><strong>Вам осталось только подтвердить свой e-mail.</strong></p>\r\n";
        $msg_html .= "<p><strong>Для этого перейдите по ссылке </strong><a href='". $url."'>$url</a></p>\r\n";
        $msg_html .= "</body></html>";
         
       // переопределяю email для проверки работы. 
        $email = 'pantera_200792@mail.ru'; 
        echo $email;
        Yii::$app->mailer->compose()
            ->setFrom('admin@klisl.com') //не надо указывать если указано в common\config\main-local.php
            ->setTo($email) // кому отправляем - реальный адрес куда придёт письмо формата asdf @asdf.com
            ->setSubject('Подтверждение регистрации.') // тема письма
            ->setTextBody($msg) // текст письма без HTML
            ->setHtmlBody($msg_html) // текст письма с HTML
            ->send();
        return 0;
    }
    /**
     * Registers user
     *
     * @return User|null the saved model or null if saving fails
     */
    public function register()
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
        
     
        $user->activator = md5($email.time());
        
        //$user->generateAuthKey();
        $rbac = \Yii::$app->authManager;
        $visitorRole = $rbac->getRole('visitor');
        
        $transaction = Yii::$app->db->beginTransaction();
        try{
           if ($user->save()) {              
              $account->username = $user->username;
              $rbac->assign($visitorRole, $user->id);
              if( $account->save()){
//              echo self::mail_subscription_activation(
//              $email, $user->activator);
                  if ($operation->save()) {
                        
                        $journal->id_account = $account->id;
                        $journal->id_operation = $operation->id;
                        $journal->save();

                        $transaction->commit();
                    }
                  return $user; 
              }
           }
        }catch(\Throwable $e){
            $transaction->rollBack();
        }
        return null;
    }
}