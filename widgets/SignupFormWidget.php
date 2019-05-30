<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;
use app\models\SignupForm;

class SignupFormWidget extends Widget
{
  public function run()
  {
    if (Yii::$app->user->isGuest) {
      $modelSign = new SignupForm();
      return $this->render('signupFormWidget', [
        'model' => $modelSign
      ]);
    } else {
      return;
    }
  }
}
