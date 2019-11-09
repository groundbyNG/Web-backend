<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\HttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;
use app\models\User;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\SearchForm;
use app\models\AddCarForm;
use app\models\Category;
use app\models\Orders;
use app\models\OrderItem;
use yii\helpers\Url;
use app\models\Car;

class SiteController extends Controller
{
  /**
   * {@inheritdoc}
   */
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'only' => ['logout', 'bucket'],
        'rules' => [
          [
            'actions' => ['logout', 'bucket'],
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

  public function actionExistsError() {
    return $this->render('error', [
      'name' => 'User is exists',
      'message' => 'User is exists'
    ]);
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
    $model = new AddCarForm();
    return $this->render('product', [
      'car' => $car,
      'category' => $category,
      'model' => $model
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
      $result = $modelSign->signup();
      if ($result == 'not valid') {
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
        return \yii\widgets\ActiveForm::validate($modelSign);
      } else if ($result == 'exists') {
        $this->redirect(Url::to(['site/exists-error']));
      } else {
        $user = $result;
        if (Yii::$app->getUser()->login($user)) {
          $newOrder = new Orders();
          $newOrder->status = false;
          $newOrder->user_id = Yii::$app->user->identity->getId();
          $newOrder->save();
          return $this->goHome();
        }
      }
    }
  }

  public function actionLogout()
  {
    Yii::$app->user->logout();
    return $this->goHome();
  }

  public function actionAddBucket()
  {
    $model = new AddCarForm();
    if ($model->load(Yii::$app->request->post())) {
      if ($model->addToBucket()) {
        $this->redirect(Url::to(['site/bucket']));
      }
    }
  }

  public function actionRemoveBucket($id)
  {
    if (OrderItem::findOne($id)->delete()) {
      $this->redirect(Url::to(['site/bucket']));
    } else {
      return 'Remove error';
    }
  }

  public function actionBuyBucket($id)
  {
    if (OrderItem::deleteAll("order_id = $id")) {
      $this->redirect(Url::to(['site/bucket']));
    } else {
      return 'Remove error';
    }
  }

  public function actionBucket()
  {
    $order = Orders::findOne([
      'user_id' => Yii::$app->user->identity->getId(),
      'status' => 0
    ]);
    $order_items = OrderItem::findAll(['order_id' => $order->id]);
    $func = function ($value) {
      $car = Car::findOne($value->car_id);
      $category = strtolower(Category::findOne($car->category_id)->name);
      return [
        'quantity' => $value->quantity,
        'category' => $category,
        'name' => $car->name,
        'year' => $car->year,
        'price' => $car->price,
        'id' => $value->id
      ];
    };
    $cars = array_map($func, $order_items);
    return $this->render('bucket', [
      'cars' => $cars,
      'order_id' => $order->id
    ]);
  }
}
