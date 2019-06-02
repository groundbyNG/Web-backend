<?php
use app\assets\ProductAsset;
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

ProductAsset::register($this);

$this->title = $car->name;
?>
 <div class="display-container product-content">
      <h1><?= $car->name ?></h1>
      <div class="row">
        <div class="col-lg-6 col-sm-12">
          <div class="swiper-container">
            <div class="swiper-wrapper">
            <?php $uniqueLink = $category . '/' . strtolower($car->name); ?>
              <div class="swiper-slide">
                <?php echo "<img src='img/$uniqueLink/1.jpg' alt='car' />"; ?>
              </div>
              <div class="swiper-slide">
                <?php echo "<img src='img/$uniqueLink/2.jpg' alt='car' />"; ?>
              </div>
              <div class="swiper-slide">
                <?php echo "<img src='img/$uniqueLink/3.jpg' alt='car' />"; ?>
              </div>
            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
        <div class="col-lg-6 col-sm-12">
          <h2>Features</h2>
          <ul>
            <li>
              <b>Body type: </b> 
              <?= $category ?>
            </li>
            <li>
              <b>Year: </b> 
              <?= $car->year ?>
            </li>
            <li>
              <b>Engine: </b> 
              <?= $car->engine ?>
            </li>
            <li>
              <b>Transmission: </b> 
              <?= $car->transmission ?>
            </li>
            <li>
              <b>Weight: </b>
              <?= $car->weight ?> кг
            </li>
          </ul>
          <h2>Description</h2>
          <p>
          <?= $car->description ?>
          </p>
          <h2>Options</h2>
          <?php $form = ActiveForm::begin([
            'action' => ['/site/add-bucket'],
            'options' => [
              'class' => 'info-c',
              'method' => 'post'
            ]
          ]); ?>
            <div class="info-c__io-block">
              <output name="result"><?= $car->price ?>$</output>
              <?php
              echo $form
                ->field($model, 'car_id', [
                  'template' => "{label}\n{input}",
                  'inputOptions' => [
                    'type' => 'hidden',
                    'value' => $car->id
                  ]
                ])
                ->hint(false)
                ->label(false);

              echo $form
                ->field($model, 'quantity', [
                  'template' => "{label}\n{input}",
                  'inputOptions' => [
                    'required' => 'true',
                    'value' => "1",
                    'max' => "100",
                    'min' => "1"
                  ]
                ])
                ->input('number', [
                  'oninput' => "result.value=($car->price*value)+'$'"
                ])
                ->hint(false)
                ->label(false);
              ?>
            </div>
            <?php if (Yii::$app->user->identity) {
              echo Html::submitButton('Add to bucket', [
                'class' => 'style-button'
              ]);
              if (Yii::$app->user->identity->getRole() == 'admin') {
                echo Html::a(
                  'Edit',
                  Url::to(['admin/update', 'carId' => $car->id]),
                  ['class' => 'style-button']
                );
                echo Html::a(
                  'Delete',
                  Url::to(['admin/delete', 'carId' => $car->id]),
                  ['class' => 'style-button']
                );
              }
            } else {
              echo "<b>Please login, to buy a car</b>";
            } ?>
        <?php ActiveForm::end(); ?>
        </div>
      </div>
    </div>