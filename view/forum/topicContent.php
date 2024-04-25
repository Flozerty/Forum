<?php
    $topic = $result["data"]['topic']; 
    $posts = $result["data"]['posts']; 
?>

<h1><?= $topic ?></h1>
<p><?= $topic->getIntro() ?></p>

<form action="" method="post" id="newPostForm">
  <label for="newPost"></label>
  <input type="text" id="newPost" name="newPost" placeholder="ajoutez un commentaire">
</form>

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
<?php }