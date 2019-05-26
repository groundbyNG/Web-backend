<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use app\assets\AppAsset;

$homeUrl = Url::home();

AppAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,  maximum-scale=1.0" />
    <link
      href="https://fonts.googleapis.com/css?family=Poppins"
      rel="stylesheet"
    />
     <?php $this->registerCsrfMetaTags(); ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head(); ?>
</head>
<body>
<?php $this->beginBody(); ?>
<header class='row'>
<?= Html::a('<img src="img/logo.png" alt="logo" class="logo" />', $homeUrl, [
  'class' => 'header__link'
]) ?>
  <div class="right-block col-sm-1 col-md-10 col-lg-5">
    <div class="right-block__btn">
      <i class="ion-md-menu"></i>
    </div>
    <div class="right-block__menu row">
      <?php
      $menuItems = [
        Html::a('Retheme', "#", [
          'id' => "toggle-theme",
          'class' => 'right-block__link col-sm-12 col-md-2 col-lg-2',
          'data-modal-open' => ''
        ])
      ];
      if (Yii::$app->user->isGuest) {
        $menuItems[] = Html::a('Registration', "#regisModal", [
          'class' => 'right-block__link col-sm-12 col-md-2 col-lg-2',
          'data-modal-open' => ''
        ]);
        $menuItems[] = Html::a('Login', "#loginModal", [
          'class' => 'right-block__link col-sm-12 col-md-2 col-lg-2',
          'data-modal-open' => ''
        ]);
      } else {
        $menuItems[] = Html::a('Logout', "/site/logout", [
          'class' => 'right-block__link col-sm-12 col-md-2 col-lg-2'
        ]);
        $menuItems[] = Html::a('Bucket', "/site/bucket", [
          'class' => 'right-block__link col-sm-12 col-md-2 col-lg-2'
        ]);
      }
      foreach ($menuItems as $item) {
        echo $item;
      }
      ?>
    </div>
  </div>
    </header>
    <div id="loginModal" style="display:none">
  <form>
    <h2>
      <b>Log in</b>
    </h2>
    <p>
      <input
        class="modal__field"
        type="email"
        name="email"
        placeholder="Email..."
      />
      <input
        class="modal__field"
        type="password"
        name="password"
        placeholder="Password..."
      />
    </p>
    <p><input type="submit" class="modal__submit-btn" value="Sign in" /></p>
  </form>
</div>
<div class="modal">
  <div class="modal-inner">
    <i data-modal-close class="ion-md-close"></i>
    <div class="modal-content"></div>
  </div>
</div>
<div id="regisModal" style="display:none">
  <form>
    <h2>
      <b>Registration</b>
    </h2>
    <p>
      <input
        class="modal__field"
        type="email"
        name="email"
        placeholder="Email..."
      />
      <input
        class="modal__field"
        type="password"
        name="password"
        placeholder="Password..."
      />
    </p>
    <p><input type="submit" class="modal__submit-btn" value="Sign up" /></p>
  </form>
</div>

    <?= $content ?>

    <footer>
    <?= Html::a(
      '<img src="img/logo.png" alt="logo" class="logo" />',
      $homeUrl,
      [
        'class' => 'footer__link'
      ]
    ) ?>
  <div class="pages-block col-lg-4 col-md-6 col-sm-6">
      <?= Html::a('Contacts', '/site/contacts', [
        'class' => 'pages-block__link col-lg-6 col-md-6 col-sm-6'
      ]) ?>
      <?= Html::a('About us', '/site/about-us', [
        'class' => 'pages-block__link col-lg-6 col-md-6 col-sm-6'
      ]) ?>
  </div>
  <div class="social">
    <a class="social__link" href="https://vk.com"
      ><i class="ion-logo-vk"></i
    ></a>
    <a class="social__link" href="https://facebook.com"
      ><i class="ion-logo-facebook"></i
    ></a>
    <a class="social__link" href="https://instagram.com"
      ><i class="ion-logo-instagram"></i
    ></a>
  </div>
</footer>


<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
