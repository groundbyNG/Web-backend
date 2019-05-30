<?php
use app\assets\IndexAsset;
use yii\helpers\Html;
use yii\helpers\Url;

IndexAsset::register($this);

$this->title = 'Main page';

$aboutUrl = Url::to(['site/about']);
$contactsUrl = Url::to(['/site/contact']);
$productsUrl = Url::to(['/site/products']);
?>

<div class="display-container main-content">
      <div class="shade">
        <div class="main-content__title-container">
          <h1 class="title-container__title">
            Revolutionary innovation in the auto industry
          </h1>
        </div>
        <div class="main-content__links-container">
          <div
            class="links-container__link-container col-lg-4 col-md-4 col-sm-4"
          >
          <?= Html::a('Contacts', $contactsUrl, [
            'class' => 'link-container__link'
          ]) ?>
          </div>
          <div
            class="links-container__link-container col-lg-4 col-md-4 col-sm-4"
          >
          <?= Html::a('About us', $aboutUrl, [
            'class' => 'link-container__link'
          ]) ?>
          </div>
          <div
            class="links-container__link-container col-lg-4 col-md-4 col-sm-4"
          >
            <?= Html::a('Choose a car...', $productsUrl, [
              'class' => 'link-container__link'
            ]) ?>
          </div>
        </div>
      </div>
    </div>