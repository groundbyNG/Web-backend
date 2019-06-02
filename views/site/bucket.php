<?php
use app\assets\ProductAsset;
use yii\helpers\Html;
use yii\helpers\Url;

ProductAsset::register($this);

$this->title = 'Bucket';
?>

<div class="display-container bucket-content">
      <h1>Bucket</h1>
      <form action="#">
        <div class="row">
          <div class="col-lg-8 col-sm-12">
            <h2>Selected items:</h2>
            <ul class="list">
            <?php foreach ($cars as $car): ?>
            <li>
                <div class="list__item">
                  <div class="d-flex">
                  <?php $uniqueLink =
                    $car['category'] . '/' . strtolower($car['name']); ?>
                  <?php echo "<img src='img/$uniqueLink/1.jpg' alt='car' />"; ?>
                    <div>
                      <h3><?= $car['name'] ?></h3>
                      <p><?= $car['year'] ?></p>
                    </div>
                  </div>
                  <div>
                    <span>Quantity: <?= $car['quantity'] ?></span>
                    <b><?= $car['price'] * $car['quantity'] ?>$</b>
                    <?= Html::a(
                      '<i class="delete-btn ion-md-close"></i>',
                      Url::to(['site/remove-bucket', 'id' => $car['id']])
                    ) ?>
                  </div>
                </div>
              </li>
            <?php endforeach; ?>
            </ul>
            <h2>Price: <?php
            $price = 0;
            foreach ($cars as $car) {
              $price += $car['price'] * $car['quantity'];
            }
            echo $price;
            ?>$</h2>
            <div class="address">
              <label for="address"
                >Input shipping address:

                <input type="address" id="address" name="address" />
              </label>
            </div>
            <form class="ship-type">
              <p>Shipping method:</p>
              <ul class="ship-type__methods">
                <li>
                  <label
                    ><input name="ship" type="radio" value="free" />Free
                    Shipping</label
                  >
                </li>
                <li>
                  <label
                    ><input
                      name="ship"
                      type="radio"
                      value="standart"
                    />Standart (30byn)</label
                  >
                </li>
                <li>
                  <label
                    ><input name="ship" type="radio" value="dhl" />DHL
                    (60byn)</label
                  >
                </li>
              </ul>
            </div>
          </form>
          <div class="col-lg-4 col-sm-12 right-block">
            <img src="./img/sell_icon.png" alt="" />
            <?= Html::a(
              'Buy',
              Url::to(['site/buy-bucket', 'id' => $order_id]),
              ['class' => "style-button"]
            ) ?>
            <!-- <button class="style-button" type="submit">Buy</button> -->
          </div>
        </div>
      </form>
    </div>