<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use app\assets\ContactsAsset;

ContactsAsset::register($this);

$this->title = 'Contacts';
?>
 <div class="display-container">
      <div class="c-about">
        <h1 class="c-about__title">
          Contacts
        </h1>
        <ul>
          <li><b>email:</b> admin@admin.com</li>
          <li><b>phone number:</b> +37529123456</li>
          <li><b>address:</b> Belarus, Vitebsk</li>
        </ul>
        <div class="c-about__image-container">
          <div id="map"></div>
        </div>
      </div>
    </div>
