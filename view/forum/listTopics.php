<?php
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
?>

<h1>Liste des topics</h1>

<?php foreach($topics as $topic) { ?>
<p>
  <a href="index.php?ctrl=forum&action=topicContent&id=<?= $topic->getId() ?>"><?= $topic ?></a> par
  <?= $topic->getUser() ?>
</p>
<?php }