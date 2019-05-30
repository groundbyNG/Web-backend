<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use app\models\CreateCarForm;
use app\models\Category;
use app\models\Car;
use yii\web\UploadedFile;

class AdminController extends Controller
{
  /**
   * {@inheritdoc}
   */
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'rules' => [
          [
            'actions' => ['index', 'update', 'delete'],
            'allow' => true,
            'roles' => ['@']
          ]
        ]
      ]
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function actions()
  {
    return [
      'error' => [
        'class' => 'yii\web\ErrorAction'
      ],
      'captcha' => [
        'class' => 'yii\captcha\CaptchaAction',
        'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
      ]
    ];
  }

  /**
   * Displays homepage.
   *
   * @return string
   */
  public function actionIndex()
  {
    if (Yii::$app->user->identity->getRole() == 'admin') {
      $categories = Category::find()
        ->orderBy('name')
        ->all();
      $model = new CreateCarForm();
      if ($model->load(Yii::$app->request->post())) {
        $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
        $model->id = Yii::$app->request->getQueryParam('id');
        $result = $model->id ? $model->update() : $model->create();
        return $result ? $this->redirect(['site/products']) : "Operation error";
      } else {
        return $this->render('index', [
          'model' => $model,
          'categories' => $categories,
          'method' => 'Create',
          'car' => ''
        ]);
      }
    } else {
      return 'Access denied';
    }
  }

  public function actionUpdate($carId)
  {
    if (Yii::$app->user->identity->getRole() == 'admin') {
      $car = Car::findOne($carId);
      $categories = Category::find()
        ->orderBy('name')
        ->all();
      $model = new CreateCarForm();
      return $this->render('index', [
        'model' => $model,
        'categories' => $categories,
        'car' => $car,
        'method' => 'Update'
      ]);
    } else {
      return 'Access denied';
    }
  }
  public function actionDelete($carId)
  {
    if (Yii::$app->user->identity->getRole() == 'admin') {
      $car = Car::findOne($carId);
      $model = new CreateCarForm();
      $model->deleteImages($car);
      $car->delete();
      $this->redirect(['site/products']);
    } else {
      return 'Access denied';
    }
  }
}
