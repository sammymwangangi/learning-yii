<?php

use yii\helpers\Url;
use yii\grid\GridView;
use app\models\Post;

?>
<a href="<?= Url::to(['site/add-post'])?>" class="btn btn-primary">Add Post</a>


<?= GridView::widget([
    'dataProvider' => $sqlProvider,
    'columns' => [
      ['class' => 'yii\grid\SerialColumn'],

      'id',
      'user_id',
      'name',
      'body',
      // action buttons
      [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{update} {delete}'
      ],

    ],
]) ?>

