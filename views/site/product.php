<?php
use app\assets\ProductAsset;
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;

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
          <form class="info-c" oninput="result.value=(number.value*5000)+'$'">
            <div class="info-c__io-block">
              <output name="result"><?= $car->price ?>$</output>
              <input
                required
                value="1"
                max="100"
                min="1"
                type="number"
                name="number"
              />
            </div>
            <?php if (Yii::$app->user->identity) {
              echo Html::a(
                'Add to bucket',
                ['/site/bucket'],
                ['class' => 'style-button']
              );
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
          </form>
        </div>
      </div>
    </div>