<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\imagine\Image;
use yii\helpers\FileHelper;

class CreateCarForm extends Model
{
  public $id;
  public $name;
  public $category_id;
  public $year;
  public $price;
  public $engine;
  public $transmission;
  public $weight;
  public $description;
  public $imageFiles;
  /**
   * @return array the validation rules.
   */
  public function rules()
  {
    return [
      [
        [
          'name',
          'category_id',
          'year',
          'price',
          'engine',
          'transmission',
          'weight',
          'description'
        ],
        'required'
      ],
      [['imageFiles'], 'image', 'maxFiles' => 3]
    ];
  }

  public function create()
  {
    if ($this->validate()) {
      $car = new Car();
      $car->name = $this->name;
      $car->category_id = $this->category_id;
      $car->year = $this->year;
      $car->price = $this->price;
      $car->engine = $this->engine;
      $car->transmission = $this->transmission;
      $car->weight = $this->weight;
      $car->description = $this->description;

      if ($car->save()) {
        if ($this->imageFiles) {
          $this->saveImages();
        }
        return true;
      }
    }
    return false;
  }
  public function update()
  {
    if ($this->validate()) {
      $car = Car::findOne($this->id);
      $car->name = $this->name;
      $car->category_id = $this->category_id;
      $car->year = $this->year;
      $car->price = $this->price;
      $car->engine = $this->engine;
      $car->transmission = $this->transmission;
      $car->weight = $this->weight;
      $car->description = $this->description;
      if ($car->save()) {
        if ($this->imageFiles) {
          $this->saveImages();
        }
        return true;
      }
    }
    return false;
  }

  private function saveImages()
  {
    $categoryName = strtolower(Category::findOne($this->category_id)->name);
    $carName = strtolower($this->name);
    $fileIndex = 1;
    $path =
      Yii::getAlias('@app') . '/web/img/' . $categoryName . '/' . $carName;
    FileHelper::createDirectory($path, $mode = 0777, $recursive = true);
    foreach ($this->imageFiles as $file) {
      $file->saveAs(
        Yii::getAlias('@app') .
          '/web/img/' .
          $categoryName .
          '/' .
          $carName .
          '/' .
          $fileIndex .
          '.' .
          $file->extension
      );
      $fileIndex++;
    }
  }
  public function deleteImages($car)
  {
    $categoryName = strtolower(Category::findOne($car->category_id)->name);
    $carName = strtolower($car->name);
    FileHelper::removeDirectory(
      Yii::getAlias('@app') . '/web/img/' . $categoryName . '/' . $carName
    );
    return true;
  }
}
