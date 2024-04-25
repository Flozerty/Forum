<?php
  $popularTopics = $result["data"]['popularTopics']; 
  $lastTopics = $result["data"]['lastTopics']; 
?>

<h1>BIENVENUE SUR FORUM, le forum</h1>

<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit ut nemo quia voluptas numquam, itaque ipsa soluta
  ratione eum temporibus aliquid, facere rerum in laborum debitis labore aliquam ullam cumque.</p>

<p>
  <a href="index.php?ctrl=security&action=login">Se connecter</a>
  <a href="index.php?ctrl=security&action=register">S'inscrire</a>
</p>

<hr>

<section id="popular">
  <h2>Les topics populaires</h2>

  <?php foreach ($popularTopics as $topic) { ?>
  <div class="popularTopic">
    <?= $topic->getTitle() ?>
    <?= $topic->getNbPosts() ?> posts
    Créé par <?= $topic->getUser() ?> le <?= $topic->getCreationDate() ?>
  </div>
  <?php } ?>

</section>

<hr>

<section id="lastTopics">
  <h2>Les dernières créations</h2>

  <?php foreach ($lastTopics as $topic) { ?>
  <div class="lastTopic">
    <?= $topic->getTitle() ?>
    Créé par <?= $topic->getUser() ?> le ( => il y a) <?= $topic->getCreationDate() ?>
  </div>
  <?php } ?>

</section>

<hr>

<section id="lastPosts">
  <h2>Les derniers topics actifs</h2>

</section>