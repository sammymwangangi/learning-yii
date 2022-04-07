<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Post;
use app\models\Users;
use yii\data\SqlDataProvider;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }


    //add user
    public function actionAdd(){

      $model = new Users();
      $model->scenario = 'add';
      if ($model->load(Yii::$app->request->post())) {
        if ($model->validate()) {

        if ($model->addUser()){
          //return a success message to the user
          Yii::$app->getSession()->setFlash('success', "User added successfully");

        } else {
          //return error message
          Yii::$app->getSession()->setFlash('error', " User encountered an error");

        }
      }

      }

      return $this->render('add',[
          'model'=>$model
      ]);


    }
    //edit user
    public function actionEdit($id){

        $model = Users::find()->where('id=:id',['id'=>$id])->limit(1)->one();
        //check for empty results
        if (empty($model)) {
          Yii::$app->getSession()->setFlash('error', "User not found");
          return $this->redirect(['site/add']);
        }
        $model->scenario = 'edit';
        if ($model->load(Yii::$app->request->post())) {
          if ($model->validate()) {
            if ($model->editUser($model->id)) {

              Yii::$app->getSession()->setFlash('success', "User updated successfully");


            } else  {
              Yii::$app->getSession()->setFlash('error', " User encountered an error");

            }

          }

        }
        return $this->render('edit',['model'=>$model]);

    }

    //action list users
    public function actionList(){

      $list = Users::find()->where(['status'=>1])->all();
      return $this->render('list',[
        'list'=>$list
      ]);
    }

    //action delete user
    public function actionDelete($id){

        $model = Users::find()->where('id=:id',['id'=>$id])->limit(1)->one();
        if (empty($model)) {
          Yii::$app->getSession()->setFlash('error', "User not found");
          return $this->redirect(['site/list']);
        }

        if ($model->deleteUser($model->id)) {
          Yii::$app->getSession()->setFlash('success', "User deleted successfully");
            return $this->redirect(['site/list']);


        } else {
          Yii::$app->getSession()->setFlash('error', "Error encountered when deleting user");
          return $this->redirect(['site/list']);

        }

    }

    //add post
    public function actionAddPost(){

      $post = new Post();

      $post->scenario = 'add-post';
      if ($post->load(Yii::$app->request->post())) {
        if ($post->validate()) {

        if ($post->addPost()){
          //return a success message to the post
          Yii::$app->getSession()->setFlash('success', "Post added successfully");

        } else {
          //return error message
          Yii::$app->getSession()->setFlash('error', " Post encountered an error");

        }
      }

      }

      return $this->render('add-post',[
          'post'=>$post
      ]);


    }
    //show single post

    public function actionShowPost($id){
        $post = Post::find()->one();
        if ($post === null) {
            throw new NotFoundHttpException;
        }
        return $this->render('show-post', ['post'=>$post]);
    }

    //edit post
    public function actionEditPost($id){

        $post = Post::find()->where('id=:id',['id'=>$id])->limit(1)->one();
        //check for empty results
        if (empty($post)) {
          Yii::$app->getSession()->setFlash('error', "Post not found");
          return $this->redirect(['site/add-post']);
        }
        $post->scenario = 'edit-post';
        if ($post->load(Yii::$app->request->post())) {
          if ($post->validate()) {
            if ($post->editPost($post->id)) {

              Yii::$app->getSession()->setFlash('success', "Post updated successfully");


            } else  {
              Yii::$app->getSession()->setFlash('error', " Post encountered an error");

            }

          }

        }
        return $this->render('edit-post',['post'=>$post]);

    }

    //action list Post
    public function actionListPosts(){

        $count = Yii::$app->db->createCommand('
            SELECT COUNT(*) FROM posts WHERE status=:status
        ', [':status' => 1])->queryScalar();

            $sql = 'SELECT * FROM posts WHERE status=:status';

            $sqlProvider = new SqlDataProvider ([
                'sql' => $sql,
                'params' => [':status' => 1],
                'totalCount' => $count,
                'sort' => [
                    'attributes' => [
                        'id',
                        'user_id',
                        'name' => [
                            'asc' => ['name' => SORT_ASC],
                            'desc' => ['name' => SORT_DESC],
                            'default' => SORT_DESC,
                            'label' => 'Name',
                        ],
                    ],
                ],
                'pagination' => [
                    'pageSize' => 3,
                ],
            ]);

      return $this->render('list-posts', ['sqlProvider'=>$sqlProvider]);
    }

    //action delete user
    public function actionDeletePost($id){

        $post = Post::find()->where('id=:id',['id'=>$id])->limit(1)->one();
        if (empty($post)) {
          Yii::$app->getSession()->setFlash('error', "Post not found");
          return $this->redirect(['site/list-posts']);
        }

        if ($post->deletePost($post->id)) {
          Yii::$app->getSession()->setFlash('success', "Post deleted successfully");
            return $this->redirect(['list-posts']);


        } else {
          Yii::$app->getSession()->setFlash('error', "Error encountered when deleting post");
          return $this->redirect(['list-posts']);

        }

    }
}
