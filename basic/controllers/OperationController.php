<?php

namespace app\controllers;

use Yii;
use app\models\OperationModel;
use app\models\OperationSearchModel;
use app\models\OperationSearchModel_user_view;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class OperationController extends Controller 
{
    /**
     * @inheritdoc
     */
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
                'only' => ['index', 'user_view'],
                'rules' => [
                    [
                        'actions' => ['index','user_view'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ], [
                        'actions' => ['user_view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ],
        ];
    }

    /**
     * Lists all OperationModel models.
     * @return mixed
     */
    public function actionIndex() 
    {
        $searchModel = new OperationSearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OperationModel model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) 
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new OperationModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() 
    {
        $model = new OperationModel();

        if ($model->load(Yii::$app->request->post())) {

            OperationModel::money_transfer($model);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing OperationModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) 
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing OperationModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) 
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionUser_view($id) 
    { 
        $searchModel = new OperationSearchModel_user_view();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id);
        
        return $this->render('index_user', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * Finds the OperationModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OperationModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) 
    {
        if (($model = OperationModel::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
