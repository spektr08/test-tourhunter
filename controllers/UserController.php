<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\BalanceForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

/**
 * BalanceController implements the CRUD actions for Balance model.
 */
class UserController extends Controller
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
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Balance models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new BalanceForm();
        if ($model->load(Yii::$app->request->post()) && $model->submit()) {
            Yii::$app->session->setFlash('balanceFormSubmitted');
            return $this->refresh();
        }
        
        
         $query = \app\models\BalanceHistory::find();
         $query->andFilterWhere(['user_id_to'=>Yii::$app->user->id]);
         $query->orFilterWhere(['user_id_from'=>Yii::$app->user->id]);
         
         
         $dataProvider =  new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'date' => SORT_DESC,
                ]
            ],
        ]);;
        
        $balance = \app\models\User::findOne(['id'=>Yii::$app->user->id])->balance;
        
        return $this->render('index', [
            'model'         => $model,
            'dataProvider'  => $dataProvider,
            'balance'  => $balance
        ]);
    }

}
