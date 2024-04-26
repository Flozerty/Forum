<?php 
if(isset($result["data"]['message'])) {
  $message = $result["data"]['message'];
}
?>

<form action="index.php?ctrl=security&action=register" method="post">

  <div id="userEmail">
    <label for="email">Votre email :</label>
    <input type="email" name="email" id="email" required>
  </div>

  <div id="userPseudo">
    <label for="pseudo">Pseudo :</label>
    <input type="text" name="pseudo" id="pseudo" required>
  </div>

  <div id="userPass">
    <label for="password">Mot de passe :</label>
    <input type="password" name="password" id="password" required>
  </div>

  <div id="userPass2">
    <label for="password2">Confirmation du mot de passe :</label>
    <input type="password" name="password2" id="password2" required>
  </div>

  <input type="submit" name="submit" value="connexion">
</form>
<?php
if(isset($message)) {
echo $message;
}