<?php

namespace app\models;

use Yii;
use yii\base\Model;

class AddCarForm extends Model
{
  public $car_id;
  public $quantity;
  /**
   * @return array the validation rules.
   */
  public function rules()
  {
    return [[['car_id', 'quantity'], 'required']];
  }

  public function addToBucket()
  {
    if ($this->validate()) {
      $orderItem = new OrderItem();
      $orderItem->car_id = $this->car_id;
      $orderItem->quantity = $this->quantity;
      $order = Orders::findOne([
        'user_id' => Yii::$app->user->identity->getId()
      ]);
      if ($order) {
        $orderItem->order_id = $order->id;
      } else {
        $newOrder = new Orders();
        $newOrder->status = false;
        $newOrder->user_id = Yii::$app->user->identity->getId();
        if ($newOrder->save()) {
          $orderItem->order_id = $newOrder->id;
        } else {
          return false;
        }
      }
      if ($orderItem->save()) {
        return true;
      }
    }
    return false;
  }
}
