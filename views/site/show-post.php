<?php

use yii\bootstrap4\Html;

$this->title = $post->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p class="text-muted"><?= Html::encode($post->body) ?></p>
    

</div>
