<?php
  $listCategories = $result["data"]['listCategories']; 
?>

<h1>Liste des catégories</h1>

<?php
foreach($listCategories as $category ){ ?>
<p>
  <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>">
    <?= $category->getName() ?>
  </a>
</p>
<?php }