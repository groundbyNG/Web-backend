<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SignupForm extends Model
{
  public $email;
  public $password;

  /**
   * @return array the validation rules.
   */
  public function rules()
  {
    return [
      // username and password are both required
      [['email', 'password'], 'required'],
      [['email'], 'email']
    ];
  }

  public function signup()
  {
    if ($this->validate()) {
      if(!User::findByEmail($this->email)) {
        $user = new User();
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->role = 'user';
        return $user->save() ? $user : null;
      }
      return 'exists';
    }
    return 'not valid';
  }
}
