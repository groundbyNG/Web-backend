<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
?>

<div id="regisModal" style="display:none">
    <h2>
        <b>Signup</b>
        </h2>
        <p>
    <?php
    $form = ActiveForm::begin([
      'id' => 'signup-form',
      'enableAjaxValidation' => true,
      'action' => ['site/signup']
    ]);
    echo $form
      ->field($model, 'email', [
        'inputOptions' => [
          'class' => 'modal__field',
          'placeholder' => "Email..."
        ]
      ])
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
    <?php echo Html::submitButton('Signup', [
      'class' => 'modal__submit-btn',
      'name' => 'signup-button'
    ]); ?>
    </p>
</div>
<?php ActiveForm::end();
