<?php

use App\Session;

?>

<h1>Mes données personnelles :</h1>

<div id="myInfos">
  <section id="basicInfos">
    <p>
      <b>pseudo : </b>
      <?= Session::getUser()->getPseudo() ?>
    </p>

    <p>
      <b>date d'inscription : </b>
      <?php 
      $date = new DateTimeImmutable(Session::getUser()->getInscriptionDate());
      echo $date->format('d/m/Y à H:i')
      ?>
    </p>
  </section>

  <form id="emailInfos" action="index.php?ctrl=security&action=changeEmail" method="post">

    <p>
      <label for="actualPass"><b>Email :</b></label>
      <?= Session::getUser()->getEmail() ?>
    </p>

    <span><b>changer</b></span>
  </form>

  <form id="passwordInfos" action="index.php?ctrl=security&action=changePassword" method="post">
    <legend><b>changer de mot de passe :</b></legend>
    <p>
      <label for="actualPass">Mot de passe actuel :</label>
      <input type="password" name="actualPass" id="actualPass">
    </p>

    <p>
      <label for="newPass1">Nouveau mot de passe :</label>
      <input type="password" name="newPass1" id="newPass1">
    </p>

    <p>
      <label for="newPass2">Confirmez le mot de passe :</label>
      <input type="password" name="newPass2" id="newPass2">
    </p>
  </form>

  <form id="avatarForm" action="" method="post">
    <legend><b>changer d'avatar :</b></legend>

    <p>
      <button>Choisissez un fichier</button>
      <input type="submit" value="valider">
    </p>
  </form>

  <a href="">Supprimer mon compte</a>
</div>