<form action="ctrl=security&action=traitement&type=login" method="post">
  <div id="userPseudo">
    <label for="pseudo">Pseudo :</label>
    <input type="text" name="pseudo" id="pseudo">
  </div>

  <div id="userPass">
    <label for="password">Mot de passe :</label>
    <input type="password" name="password" id="password">
  </div>
  <input type="submit" value="connexion">
</form>

<p>Nouveau? <a href="index.php?ctrl=security&action=register">cliquez ici</a></p>