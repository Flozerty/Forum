<?php

use App\Session;

  $popularTopics = $result["data"]['popularTopics']; 
  $lastTopics = $result["data"]['lastTopics']; 
?>

<h1>BIENVENUE SUR FORUM (LE forum)</h1>

<div id="connectStatusHome">
  <?php if(Session::getUser()) { ?>
  <p>Bonjour <?= Session::getUser() ?>,</p>
  <?php } else { ?>
  <a href="index.php?ctrl=security&action=register">Inscription</a>
  <a href="index.php?ctrl=security&action=login">Connexion</a>
  <?php } ?>
</div>

<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit ut nemo quia voluptas numquam, itaque ipsa soluta
  ratione eum temporibus aliquid, facere rerum in laborum debitis labore aliquam ullam cumque.</p>

<hr>

<section id="popular">
  <h2>Les topics populaires</h2>

  <?php foreach ($popularTopics as $topic) { ?>
  <a href="index.php?ctrl=forum&action=topicContent&id=<?= $topic->getId() ?>" class="popularTopic content-bubble">

    <p class="topicTitle"><?= $topic->getCategory()->getIcone()." ".$topic->getTitle() ?></p>
    <p class="topicPosts"><?= $topic->getNbPosts() ?> posts</p>
    <p class="topicInfos"><?= $topic->getUser() ?>, le <?= $topic->getCreationDate() ?></p>
  </a>
  <?php } ?>

</section>

<hr>

<section id="lastTopics">
  <h2>Les dernières créations</h2>

  <?php foreach ($lastTopics as $topic) { ?>
  <a href="index.php?ctrl=forum&action=topicContent&id=<?= $topic->getId() ?>" class="lastTopic content-bubble">

    <div class="topicInfos">
      <p class="topicTitle"><?= $topic->getCategory()->getIcone()." ".$topic->getTitle() ?></p>
      <p class="topicUser">
        par <?= $topic->getUser() ?>,
        il y a
        <!-- On utilise la fonction de timerDelay créée dans Entity.php -->
        <?php 
        $dateCreation = $topic->getCreationDate();
        $topic->getTimeDelay($dateCreation);
        ?>

      </p>
    </div>
    <p class="topicIntro"><?= $topic->getIntro() ?></p>

  </a>
  <?php } ?>
</section>

<hr>

<section id="lastPosts">
  <h2>Les derniers topics actifs</h2>
  <div class="lastActiveTopic content-bubble">
  </div>
</section>