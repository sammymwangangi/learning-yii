<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Edit Post';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to Edit Post:</p>
    <!-- <form> -->
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <?= $form->field($post, 'name')->textInput(['autofocus' => true]) ?>

        <?= $form->field($post, 'body')->textarea(['autofocus' => true]) ?>

        <div class="form-group">
            <div class="offset-lg-1 col-lg-11">
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>
      <!-- </form> -->
    <?php ActiveForm::end(); ?>

</div>
