<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
?>

<div id="loginModal" style="display:none">
    <h2>
        <b>Login</b>
        </h2>
        <p>
    <?php
    $form = ActiveForm::begin([
      'id' => 'login-form',
      // 'enableAjaxValidation' => true,
      'action' => ['site/login']
    ]);
    echo $form
      ->field($model, 'email', [
        'inputOptions' => [
          'class' => 'modal__field',
          'placeholder' => "Email..."
        ]
      ])
      ->textInput()
      ->input('email')
      ->label(false);
    echo $form
      ->field($model, 'password', [
        'inputOptions' => [
          'class' => 'modal__field',
          'placeholder' => "Password..."
        ]
      ])
      ->passwordInput()
      ->label(false);
    ?>
    </p>
    <p>
    <?php echo Html::submitButton('Login', [
      'class' => 'modal__submit-btn',
      'name' => 'login-button'
    ]); ?>
    </p>
</div>
<?php ActiveForm::end();
