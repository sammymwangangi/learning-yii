<?php

use yii\helpers\Url;
use yii\grid\GridView;
use app\models\Post;

?>
<a href="<?= Url::to(['site/add-post'])?>" class="btn btn-primary">Add Post</a>


<?= GridView::widget([
    'dataProvider' => $sqlProvider,
    'columns' => [
      'id',
      'user_id',
      'name',
      'body',
      'action'
    ],
]) ?>

