<?php
use app\assets\ProductsAsset;
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

ProductsAsset::register($this);

$this->title = 'Products';
?>
<div class="products-content row">
      <button class="accordion col-sm-12">
        Show filters
      </button>
      <div class="sidebar col-sm-12 col-md-12 col-lg-2">
        <?php $form = ActiveForm::begin([
          'id' => 'products-search',
          'action' => ['site/products-search'],
          'options' => ['method' => 'post']
        ]); ?>
          <?php echo $form
            ->field($model, 'find', [
              'template' => "{label}\n{input}",
              'inputOptions' => [
                'placeholder' => "Type car name"
              ],
              'options' => [
                'class' => 'search-block col-lg-12'
              ]
            ])
            ->input('search')
            ->hint(false)
            ->label(false); ?>

          <h3 class="headline">Categories</h3>
          <div class="sidebar__categories">
            <ul>
                <?php
                $checkedArr = $model->categories;
                echo $form
                  ->field($model, 'categories[]')
                  ->checkboxList($categories, [
                    'item' => function (
                      $index,
                      $label,
                      $name,
                      $checked,
                      $value
                    ) use ($checkedArr) {
                      $checked =
                        $checkedArr && in_array($value, $checkedArr)
                          ? 'checked'
                          : '';
                      return "<label class='container'><input type='checkbox' {$checked} name='{$name}' value='{$value}'>{$label}<span class='checkmark'></span></label>";
                    }
                  ])
                  ->label(false);
                ?>
            </ul>
          </div>
          <div>
            <h3 class="headline">Year</h3>
            <div class="range">
              <div id="slider"></div>
              <span id="slider-value"></span>
              <?php echo $form
                ->field($model, 'range', [
                  'template' => "{label}\n{input}",
                  'inputOptions' => [
                    'type' => "hidden",
                    'id' => "slider-output"
                  ]
                ])
                ->hint(false)
                ->label(false); ?>
            </div>
          </div>
          <div class="sidebar__submit col-lg-12">
          <?php echo Html::submitButton('Search', [
            'class' => 'style-button'
          ]); ?>
          </div>
        <?php ActiveForm::end(); ?>
        <div class="sidebar__submit col-lg-12">
        <?php if (
          Yii::$app->user->identity &&
          Yii::$app->user->identity->getRole() == "admin"
        ) {
          echo Html::a('Create new car', Url::to(['admin/index']), [
            'class' => "style-button"
          ]);
        } ?>
        </div>
      </div>
      <div class="sidebar-content col-sm-12 col-md-12 col-lg-10">
        <div class="display-container">
          <div class="row justify-content-center">
          <?php foreach ($cars as $car): ?>
            <div class="col-lg-4 col-md-6 d-flex justify-content-center">
              <div class="sidebar-content__elem">
              <?php
              $uniqueLink =
                strtolower(
                  array_values(
                    array_filter(
                      $categories,
                      function ($category, $id) use ($car) {
                        return $id == $car->category_id;
                      },
                      ARRAY_FILTER_USE_BOTH
                    )
                  )[0]
                ) .
                '/' .
                strtolower($car->name);
              $e = "<div class='sidebar-content__border'>
                <img src='img/$uniqueLink/1.jpg' alt='car' />
                <p>$car->name</p>
              </div>";
              ?>
              <?= Html::a($e, Url::to(['site/product', 'id' => $car->id])) ?>
              </div>
            </div>
          <?php endforeach; ?>
          </div>
          <div class="d-flex justify-content-center">
            <?php echo LinkPager::widget([
              'pagination' => $pagination,
              'options' => [
                'class' => 'pagination'
              ],
              'disabledPageCssClass' => 'pagination__link-disabled',
              'activePageCssClass' => 'pagination__link-active',
              'prevPageCssClass' => 'pagination__link',
              'nextPageCssClass' => 'pagination__link',
              'pageCssClass' => 'pagination__link'
            ]); ?>
          </div>
        </div>
      </div>
    </div>