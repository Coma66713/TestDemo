<?php

namespace app\controllers;

use Yii;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\AccountModel;
use app\models\AccountSearchModel;
use app\models\AccountSearchModel_user_index;
use app\models\OperationSearchModel_view;
use app\models\UserCreateForm;
use app\models\UserEditForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


/**
 * AccountController.
 */
class AccountController extends Controller 
{
    public function behaviors() 
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'user_view','user_index', 'deposit_to_an_account', 'money_transfer'],
                'rules' => [
                    [
                        'actions' => ['index','deposit_to_an_account','money_transfer','user_view','user_index'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ], [
                        'actions' => ['user_view','user_index','money_transfer'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ],
        ];
    }

    /**
     * Lists all AccountModel models.
     * @return mixed
     */
    public function actionIndex() 
    {
        $searchModel = new AccountSearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUser_index($id) 
    {
        $searchModel = new AccountSearchModel_user_index();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id);
        
        return $this->render('user_index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AccountModel model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) 
    {
        $searchModel = new OperationSearchModel_view();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id);
 
        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new AccountModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() 
    {
        $model = new UserCreateForm();

        if($model->load(Yii::$app->request->post()) && ($user = $model->create())) {
            \Yii::$app->session->setFlash('user_create_done', 
                        "User create successfully");
            return $this->redirect(['index',]);
        }
        \Yii::$app->session->setFlash('user_create_error', 
                        "User create not successfully, try again please.");
        return $this->render('create_user', [
            'model' => $model,
        ]);
    }
    
     public function actionUpdate($id)
    {
         $model = new UserEditForm();
        
        if ($model->load(Yii::$app->request->post()) && $user = $model->edit($id)) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('update_user', [
            'model' => $model,
        ]);
    }
    /**
     * Зачисление на счет.
     * If Deposit_to_an_account is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeposit_to_an_account($id) 
    {
        $model = $this->findModel($id);
        $summ = $model->summ;
        $username = $model->username;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->summ > 0) {
               if( AccountModel:: deposit_to_an_account($model, $username, $summ)) {
                    \Yii::$app->session->setFlash('deposit_done', 
                        "Deposit of funds to the account is completed");
                    return $this->redirect(['index',]); 
               }else
                    \Yii::$app->session->setFlash('deposit_error', 
                        "Deposit of funds to the account was not completed");
            }
        }
        
        return $this->render('deposit_to_an_account', [
            'model' => $model,
        ]);
    }
    /**
     * Зачисление на счет.
     * If Money_transfer is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionMoney_transfer($id) 
    {
        $model = $this->findModel($id);
        $summ = $model->summ;
        $username = $model->username;

        if ($model->load(Yii::$app->request->post())) {
            if (($username != $model->username) && ($summ - $model->summ > 0) && ($model->summ > 0)) {
                if(AccountModel:: money_transfer($model, $username, $summ)){
                    \Yii::$app->session->setFlash('transfer_done', 
                        "Transfer of funds to the account is completed");
                    if(Yii::$app->user->can('admin')) {
                        return $this->redirect(['index', 'id' => $model->id]);
                    } elseif(Yii::$app->user->can('visitor')) {
                        return $this->redirect(['user_index', 'id' => $model->id]);
                    }
                } else
                    \Yii::$app->session->setFlash('transfer_error', 
                        "Transfer of funds to the account was not completed");
            }
        }
        
        return $this->render('money_transfer', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AccountModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) 
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AccountModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AccountModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) 
    {
        if (($model = AccountModel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
