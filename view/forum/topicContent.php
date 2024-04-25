<?php
    $topic = $result["data"]['topic']; 
    $posts = $result["data"]['posts']; 
?>

<h1><?= $topic ?></h1>
<p><?= $topic->getIntro() ?></p>



<!-- S'il y a déjà des messages dans le topic -->
<?php if(!empty($posts)) {
  foreach($posts as $post) { ?>
<p>
  <?= $post ?> par <?= $post->getUser() ?>
</p>
<?php }
} else { ?>
<!-- S'il n'y a aucun message -->
<p>Aucun message</p>
<?php } ?>

<form action="#" method="post" id="newPostForm">
  <textarea id="newPost" name="newPost" placeholder="ajoutez un commentaire"></textarea>
  <input type="submit" value="envoyer" class="submitButton">
</form>