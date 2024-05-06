<?php 
if(isset($result["data"]['loginMessage'])) {
  $message = $result["data"]['loginMessage'];
}
?>

<form action="index.php?ctrl=security&action=login" method="post">
  <div id="userPseudo" class="input-container">
    <label for="pseudo">Pseudo :</label>
    <input type="text" name="pseudo" id="pseudo">
  </div>

  <div id="userPass" class="input-container">
    <label for="password">Mot de passe :</label>
    <input type="password" name="password" id="password">
  </div>
  <input type="submit" name="submit" value="connexion">
</form>

<p>Nouveau? <a href="index.php?ctrl=security&action=register">cliquez ici</a></p>

<?php
if(isset($message)) {
echo $message;
}