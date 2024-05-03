<?php

use App\Session;

    $topic = $result["data"]['topic']; 
    $posts = $result["data"]['posts']; 

?>

<h1><?= $topic ?></h1>
<p><?= $topic->getIntro() ?></p>

<section id="posts-container">

  <!-- S'il y a déjà des messages dans le topic -->
  <?php if(!empty($posts)) {
  foreach($posts as $post) { ?>

  <!-- post a droite si user connecté -->
  <div class="topic-post <?= (Session::getUser() == $post->getUser()) ? "myPost" : "othersPost" ?>">
    <div class="postInfos">
      <p><?= $post->getUser() ?></p>
      <p>il y a
        <!-- On utilise la fonction de timerDelay créée dans Entity.php -->
        <?php 
        $date = $post->getPostDate();
        $post->getTimeDelay($date)
        ?>
      </p>
    </div>

    <div class="content-bubble">
      <!-- x-mark si user connecté ou admin -->
      <?php if(Session::getUser() == $post->getUser() || Session::isAdmin() == $post->getUser()) { ?>
      <i class="fa-solid fa-circle-xmark"></i>
      <?php } ?>
      <p>
        <?= $post ?>
      </p>
    </div>
  </div>

  <?php }
  } else { ?>
  <!-- S'il n'y a aucun message -->
  <p>Aucun message</p>
  <?php } ?>

</section>

<form action="#" method="post" id="newPostForm">
  <textarea id="newPost" name="newPost" cols="50" rows="10" placeholder="ajoutez un commentaire"></textarea>
  <input type="submit" value="envoyer" class="submitButton">
</form>