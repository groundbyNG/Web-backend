<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\HttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\models\User;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\SearchForm;
use app\models\Category;
use app\models\Car;

class SiteController extends Controller
{
  public $filteredCarsQuery = '';
  /**
   * {@inheritdoc}
   */
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'only' => ['logout'],
        'rules' => [
          [
            'actions' => ['logout'],
            'allow' => true,
            'roles' => ['@']
          ]
        ]
      ],
      'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
          'logout' => ['post'],
          'signup' => ['post']
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
    return $this->render('index');
  }

  public function actionContact()
  {
    return $this->render('contact');
  }

  public function actionAbout()
  {
    return $this->render('about');
  }

  public function actionProducts()
  {
    $model = new SearchForm();

    $carsQuery = Car::find();

    $pagination = new Pagination([
      'defaultPageSize' => 5,
      'totalCount' => $carsQuery->count()
    ]);
    $cars = $carsQuery
      ->orderBy('name')
      ->offset($pagination->offset)
      ->limit($pagination->limit)
      ->all();

    $categories = Category::find()
      ->orderBy('name')
      ->all();

    $checkboxCategories = [];
    foreach ($categories as $key => $value) {
      $checkboxCategories[$value->id] = $value->name;
    }

    return $this->render('products', [
      'cars' => $cars,
      'categories' => $checkboxCategories,
      'pagination' => $pagination,
      'model' => $model
    ]);
  }

  public function actionProduct($id)
  {
    $car = Car::findOne($id);
    $category = strtolower(Category::findOne($car->category_id)->name);
    return $this->render('product', [
      'car' => $car,
      'category' => $category
    ]);
  }

  public function actionProductsSearch()
  {
    $model = new SearchForm();
    if ($model->load(Yii::$app->request->post())) {
      $carsQuery = $model->search();

      $pagination = new Pagination([
        'defaultPageSize' => 5,
        'totalCount' => $carsQuery->count(),
        'params' => array_merge($_GET, [
          'find' => $model->find,
          'categories' => $model->categories,
          'range' => $model->range
        ])
      ]);

      $categories = Category::find()
        ->orderBy('name')
        ->all();

      $checkboxCategories = [];
      foreach ($categories as $key => $value) {
        $checkboxCategories[$value->id] = $value->name;
      }

      $cars = $carsQuery
        ->orderBy('name')
        ->offset($pagination->offset)
        ->limit($pagination->limit)
        ->all();

      return $this->render('products', [
        'cars' => $cars,
        'categories' => $checkboxCategories,
        'pagination' => $pagination,
        'model' => $model
      ]);
    } else {
      $find = Yii::$app->request->getQueryParam('find');
      $categories = Yii::$app->request->getQueryParam('categories');
      $range = Yii::$app->request->getQueryParam('range');
      $model->find = $find;
      $model->categories = $categories;
      $model->range = $range;
      $carsQuery = $model->search();

      $pagination = new Pagination([
        'defaultPageSize' => 5,
        'totalCount' => $carsQuery->count(),
        'params' => array_merge($_GET, [
          'find' => $model->find,
          'categories' => $model->categories,
          'range' => $model->range
        ])
      ]);

      $categories = Category::find()
        ->orderBy('name')
        ->all();

      $checkboxCategories = [];
      foreach ($categories as $key => $value) {
        $checkboxCategories[$value->id] = $value->name;
      }

      $cars = $carsQuery
        ->orderBy('name')
        ->offset($pagination->offset)
        ->limit($pagination->limit)
        ->all();

      return $this->render('products', [
        'cars' => $cars,
        'categories' => $checkboxCategories,
        'pagination' => $pagination,
        'model' => $model
      ]);
    }
  }

  // For init admin user

  // public function actionAddAdmin()
  // {
  //   $user = new User();
  //   $user->email = 'admin@admin.com';
  //   $user->role = 'admin';
  //   $user->setPassword('admin');
  //   if ($user->save()) {
  //     echo 'good';
  //   }
  // }

  public function actionLogin()
  {
    $model = new LoginForm();
    if ($model->load(Yii::$app->request->post())) {
      if ($model->login()) {
        return $this->goBack();
      } else {
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
        return \yii\widgets\ActiveForm::validate($model);
      }
    }
  }

  public function actionSignup()
  {
    $modelSign = new SignupForm();
    if ($modelSign->load(Yii::$app->request->post())) {
      if ($user = $modelSign->signup()) {
        if (Yii::$app->getUser()->login($user)) {
          return $this->goHome();
        }
      } else {
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
        return \yii\widgets\ActiveForm::validate($modelSign);
      }
    }
  }

  public function actionLogout()
  {
    Yii::$app->user->logout();
    return $this->goHome();
  }

  public function actionBucket()
  {
    return $this->render('bucket');
  }
}
