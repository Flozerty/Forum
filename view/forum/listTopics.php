<?php
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
?>

<h1>Liste des topics de <?= mb_strtoupper($category->getName()) ?></h1>

<a href="#"> <button class="addButton">Créer un nouveau topic</button></a>

<form action="#" id="createTopicForm" method="post">

  <div id="formTopicTitle">
    <label for="title"></label>
    <input type="text" id="title" name="title" placeholder="Titre du topic">
  </div>

  <textarea id="newtopicIntro" rows="5" cols="40" name="newtopicIntro"
    placeholder="ajoutez une introduction au topic"></textarea>
  <input type="submit" value="créer le topic" class="submitButton">

</form>

<?php if(!empty($topics)) {

$openTopics = [];
$closedTopics = [];

foreach($topics as $topic) {

  // On tire les topics ouverts et fermés
  if($topic->getClosed() === 1) {
    $closedTopics[] = $topic;
  } else {
    $openTopics[] = $topic;
  }
  ?>
<?php } ?>

<!-- On affiche les topics ouverts -->
<section id="openedTopic">
  <h2>Topics ouverts</h2>

  <div class="listTopics">
    <?php foreach($openTopics as $topic) { ?>

    <p><a href="index.php?ctrl=forum&action=topicContent&id=<?= $topic->getId() ?>"><?= $topic ?></a></p>
    <div class="topicInfos">
      <p class="userTopic"><?= $topic->getUser() ?></p>
      <p class="dateTopic"><?= $topic->getCreationDate() ?></p>
    </div>

    <?php } ?>
  </div>
</section>

<!-- On affiche les topics fermés -->
<section id="closedTopic">
  <h2>Topics fermés</h2>

  <?php foreach($closedTopics as $topic) { ?>

  <p>
    <a href="index.php?ctrl=forum&action=topicContent&id=<?= $topic->getId() ?>"><?= $topic ?></a>
    <?= $topic->getUser() ?>
  </p>

  <?php } ?>
</section>

<?php } else { ?>
<p>Aucun topic dans cette catégorie.</p>
<?php }