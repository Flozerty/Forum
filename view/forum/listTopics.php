<?php
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
?>

<h1>Liste des topics de <?= mb_strtoupper($category->getName()) ?></h1>

<a href="#"> <button class="addButton">Créer un nouveau topic</button></a>

<?php if(!empty($topics)) {

foreach($topics as $topic) { ?>
<p>
  <a href="index.php?ctrl=forum&action=topicContent&id=<?= $topic->getId() ?>"><?= $topic ?></a> par
  <?= $topic->getUser() ?>
</p>
<?php }
} else { ?>
<p>Aucun topic dans cette catégorie.</p>
<?php }