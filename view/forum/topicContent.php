<?php
    $topic = $result["data"]['topic']; 
    $posts = $result["data"]['posts']; 
?>

<h1><?= $topic ?></h1>
<p><?= $topic->getIntro() ?></p>

<?php if(!empty($posts)) {
  foreach($posts as $post) { ?>
<p>
  <?= $post ?> par
  <?= $post->getUser() ?>
</p>
<?php }
} else { ?>
<p>Aucun message</p>
<?php }