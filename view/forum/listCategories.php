<?php

use App\Session;

  $listCategories = $result["data"]['listCategories']; 
?>

<h1>Liste des catégories</h1>

<?php
foreach($listCategories as $category ){ ?>

<div class="categoryDiv">
  <?php if(Session::getUser() && Session::isAdmin()) { ?>
  <i class="fa-solid fa-circle-xmark"></i>
  <?php } ?>

  <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>">
    <?= $category->getName() ?>
  </a>
</div>

<?php }