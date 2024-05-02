<?php

use App\Session;

  $listCategories = $result["data"]['listCategories']; 
?>

<h1>Liste des catégories</h1>

<?php if(Session::isAdmin()) { ?>
<button class="addButton">Créer une catégorie</button>
<!-- formulaire création catégorie -->
<form action="index.php?ctrl=forum&action=addCategory" id="createForm" method="post">
  <legend>Créer une nouvelle catégorie</legend>

  <div id="formCategoryName">
    <label for="name"></label>
    <input type="text" id="name" name="name" placeholder="Nom de la catégorie" required>
  </div>
  <div id="formCategoryIcone">
    <label for="icone"></label>
    <input type="text" id="icone" name="icone" placeholder="icone" required>
  </div>
  <input type="submit" value="créer" class="submitButton">
</form>
<?php } ?>

<!-- liste des catégories -->
<section id="allCategories-container">
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
  <?php } ?>
</section>