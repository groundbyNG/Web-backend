<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Car;

class SearchForm extends Model
{
  public $find;
  public $categories;
  public $range;

  public function rules()
  {
    return [
      ['find', 'string'],
      ['categories', 'default', 'value' => null],
      ['range', 'string']
    ];
  }

  public function search()
  {
    $rangeArr = explode(' - ', $this->range);
    $startDate = $rangeArr[0];
    $endDate = $rangeArr[1];
    if ($this->categories) {
      $query = Car::find()
        ->where(['like', 'name', $this->find])
        ->andWhere(['in', 'category_id', $this->categories])
        ->andWhere("year > $startDate")
        ->andWhere("year < $endDate");
    } else {
      $query = Car::find()
        ->where(['like', 'name', $this->find])
        ->andWhere("year > $startDate")
        ->andWhere("year < $endDate");
    }
    return $query;
  }
}
