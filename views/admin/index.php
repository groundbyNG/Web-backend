<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$this->title = "$method car";
?>


<div class="display-container">
<h2>
        <b><?php echo $method; ?> car</b>
        </h2>
        <p>
    <?php
    if ($car) {
      $model->name = $car->name;
      $model->category_id = $car->category_id;
      $model->year = $car->year;
      $model->price = $car->price;
      $model->engine = $car->engine;
      $model->transmission = $car->transmission;
      $model->weight = $car->weight;
      $model->description = $car->description;
      $model->id = $car->id;
    }

    $form = ActiveForm::begin([
      'id' => 'create-form',
      'action' => $car
        ? Url::to(['admin/index', 'id' => $car->id])
        : Url::to(['admin/index'])
    ]);
    echo $form
      ->field($model, 'name', [
        'options' => [
          'class' => 'modal_block'
        ],
        'inputOptions' => [
          'class' => 'modal__field'
        ]
      ])
      ->textInput();
    echo $form
      ->field($model, 'category_id', [
        'options' => [
          'class' => 'modal_block'
        ],
        'inputOptions' => [
          'class' => 'modal__field'
        ]
      ])
      ->dropDownList(ArrayHelper::map($categories, 'id', 'name'))
      ->label('Category');
    echo $form
      ->field($model, 'year', [
        'options' => [
          'class' => 'modal_block'
        ],
        'inputOptions' => [
          'class' => 'modal__field'
        ]
      ])
      ->input('number');
    echo $form
      ->field($model, 'price', [
        'options' => [
          'class' => 'modal_block'
        ],
        'inputOptions' => [
          'class' => 'modal__field'
        ]
      ])
      ->input('number');
    echo $form
      ->field($model, 'engine', [
        'options' => [
          'class' => 'modal_block'
        ],
        'inputOptions' => [
          'class' => 'modal__field'
        ]
      ])
      ->textInput();
    echo $form
      ->field($model, 'transmission', [
        'options' => [
          'class' => 'modal_block'
        ],
        'inputOptions' => [
          'class' => 'modal__field'
        ]
      ])
      ->textInput();
    echo $form
      ->field($model, 'weight', [
        'options' => [
          'class' => 'modal_block'
        ],
        'inputOptions' => [
          'class' => 'modal__field'
        ]
      ])
      ->input('number');
    echo $form
      ->field($model, 'description', [
        'options' => [
          'class' => 'modal_block'
        ],
        'inputOptions' => [
          'class' => 'modal__field'
        ]
      ])
      ->textInput();
    echo $form
      ->field($model, 'imageFiles[]')
      ->fileInput(['multiple' => true, 'accept' => 'image/*'])
      ->label("Choose images");
    ?>
    </p>
    <p>
    <?php echo Html::submitButton($method, [
      'class' => 'style-button',
      'name' => 'create-button'
    ]); ?>
    </p>
</div>
<?php ActiveForm::end(); ?>
</div>