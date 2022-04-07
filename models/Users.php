<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;




class Users extends ActiveRecord
{

  //validations and scenarios
  public function rules(){
    return [
      // rules of dding a user
      ['fullname', 'required', 'message' => 'Please Enter The user\'s Full Name', 'on' => 'add'],
      ['fullname', 'trim', 'on' => 'add'],
      ['fullname', 'string', 'min' => 4, 'max' => 255, 'on' => 'add'],
      ['fullname', 'match', 'pattern' => "/^([A-Za-zâêîôûàèìòùäëïöüáéíóúñßç\s]*)$/", 'message' => 'Full name does not allow special characters.', 'on' => 'add'],

      ['username', 'required', 'message' => 'Please Enter The user\'s Full Name', 'on' => 'add'],
      ['username', 'trim', 'on' => 'add'],
      ['username', 'string', 'min' => 4, 'max' => 255, 'on' => 'add'],
      ['username', 'match', 'pattern' => "/^([A-Za-zâêîôûàèìòùäëïöüáéíóúñßç\s]*)$/", 'message' => 'Full name does not allow special characters.', 'on' => 'add'],

      // edit 'rules'
      ['fullname', 'required', 'message' => 'Please Enter The user\'s Full Name', 'on' => 'edit'],
      ['fullname', 'trim', 'on' => 'edit'],
      ['fullname', 'string', 'min' => 4, 'max' => 255, 'on' => 'edit'],
      ['fullname', 'match', 'pattern' => "/^([A-Za-zâêîôûàèìòùäëïöüáéíóúñßç\s]*)$/", 'message' => 'Full name does not allow special characters.', 'on' => 'edit'],

      ['username', 'required', 'message' => 'Please Enter The user\'s Full Name', 'on' => 'edit'],
      ['username', 'trim', 'on' => 'edit'],
      ['username', 'string', 'min' => 4, 'max' => 255, 'on' => 'edit'],
      ['username', 'match', 'pattern' => "/^([A-Za-zâêîôûàèìòùäëïöüáéíóúñßç\s]*)$/", 'message' => 'Full name does not allow special characters.', 'on' => 'edit'],

    ];


  }

  //return table name
  public static function tableName(){

    return "{{users}}";
  }

  //define relationships
  

  //add user
  public function addUser(){
    $model = new Users();
    $model->username = $this->username;
    $model->fullname = strtolower($this->fullname);
    $model->username_fullname = $this->username.' '.$this->fullname;
    if ($model->save()) {
      return true;
    }
    return false;
  }

    //edit user;
   public function editUser($id){
     $model = Users::find()->where('id=:id',['id'=>$id])->limit(1)->one();
     if (!empty($model)) {
       $model->username = $this->username;
       $model->fullname = strtolower($this->fullname);
       $model->username_fullname = $this->username.' '.$this->fullname;
       if ($model->save()) {
         return true;
       }
       return false;
     }
     return false;


   }

   //delete user
   public function deleteUser($id){
     $model = Users::find()->where('id=:id',['id'=>$id])->limit(1)->one();
     if (!empty($model)) {
       $model->status = 0;
       if ($model->save()) {
         return true;

       }
       return false;

     }
     return false;

   }




}
