<?php
use yii\helpers\Url;

?>
 <a href="<?= Url::to(['site/add'])?>" class="btn btn-primary">Add User</a><br>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">username</th>
      <th scope="col">FullName</th>
      <th scope="col">Use Full Name</th>
      <th scope="col">Update</th>
      <th scope="col">Delete</th>


    </tr>
  </thead>
  <tbody>
    <?php foreach ($list as  $value) {  ?>
    <tr>
      <th scope="row"><?= $value->id?></th>
      <td><?= $value->username?></td>
      <td><?= $value->fullname?></td>
      <td><?= $value->username_fullname?></td>
      <?php  //Url::to(['controller/action',....parameters])?>
      <td>  <a href="<?= Url::to(['site/edit','id'=>$value->id])?>" class="btn btn-success">Update</a></td>
      <td>  <a href="<?= Url::to(['site/delete','id'=>$value->id])?>" class="btn btn-danger">Delete</a></td>
    </tr>
  <?php } ?>
  </tbody>
</table>
