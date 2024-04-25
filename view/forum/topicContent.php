<?php
    $topic = $result["data"]['topic']; 
    $posts = $result["data"]['posts']; 
?>

<h1><?= $topic ?></h1>
<p><?= $topic->getIntro() ?></p>

<section id="posts-container">

  <!-- S'il y a déjà des messages dans le topic -->
  <?php if(!empty($posts)) {
  foreach($posts as $post) { ?>

  <div class="topic-post">
    <div class="postInfos">
      <p><?= $post->getUser() ?></p>
      <p>il y a <?= $post->getPostDate() ?></p>
    </div>
    <div class="content-bubble">
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