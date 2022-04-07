<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;




class Post extends ActiveRecord
{

  //validations and scenarios
  public function rules(){
    return [
      // rules of adding a post
      ['name', 'required', 'message' => 'Please Enter The post\'s Full Name', 'on' => 'add-post'],
      ['name', 'trim', 'on' => 'add-post'],
      ['name', 'unique', 'message' => 'Name already exists', 'on' => 'add-post'],
      ['name', 'string', 'min' => 4, 'max' => 100, 'on' => 'add-post'],
      ['name', 'match', 'pattern' => "/^([A-Za-zâêîôûàèìòùäëïöüáéíóúñßç\s]*)$/", 'message' => 'Name does not allow special characters.', 'on' => 'add-post'],

      ['body', 'required', 'message' => 'Please Enter The post\'s content', 'on' => 'add-post'],
      // ['body', 'unique', 'message' => 'Content already exists', 'on' => 'add-post'],

      // edit 'rules'
      ['name', 'required', 'message' => 'Please Enter The post\'s Full Name', 'on' => 'edit-post'],
      ['name', 'trim', 'on' => 'edit-post'],
      ['name', 'unique', 'on' => 'edit-post'],
      ['name', 'string', 'min' => 4, 'max' => 100, 'on' => 'edit-post'],
      ['name', 'match', 'pattern' => "/^([A-Za-zâêîôûàèìòùäëïöüáéíóúñßç\s]*)$/", 'message' => 'Name does not allow special characters.', 'on' => 'edit-post'],
      ['body', 'required', 'message' => 'Please Enter The post\'s content', 'on' => 'edit-post'],
      // ['body', 'unique', 'on' => 'edit-post'],
    ];


  }

  //return table name
  public static function tableName(){

    return "{{posts}}";
  }

  //define relationships

  

  //add user
  public function addPost(){
    $post = new Post();

    // Yii::info("user_id=".Yii::$app->user->id);
    $post->name = $this->name;
    $post->body = strtolower($this->body);
    $post->user_id = Yii::$app->user->identity->id;
    if ($post->save()) {
      return true;
    }
    return false;
  }

    //edit user;
   public function editPost($id){
     $post = Post::find()->where('id=:id',['id'=>$id])->limit(1)->one();
     if (!empty($post)) {
       $post->name = $this->name;
       $post->body = strtolower($this->body);
       if ($post->save()) {
         return true;
       }
       return false;
     }
     return false;


   }

   //delete user
   public function deletePost($id){
     $post = Post::find()->where('id=:id',['id'=>$id])->limit(1)->one();
     if (!empty($post)) {
       $post->status = 0;
       if ($post->save()) {
         return true;

       }
       return false;

     }
     return false;

   }




}
