<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use App\Session;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\UserManager;

class SecurityController extends AbstractController{
  // contiendra les méthodes liées à l'authentification : register, login et logout

  
        //////////////////////////////////////////////
        ////////// TRAITEMENT D'UN REGISTER //////////
        //////////////////////////////////////////////
  public function register () {

    if(isset($_POST["submit"])) {

      $userManager = new UserManager();

      $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $pass1 = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $pass2 = filter_input(INPUT_POST, "password2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);

      // fonction de redirection avec le message d'erreur
      function redirectAndMessage($message) { 
        return [
          "view" => VIEW_DIR."register.php",
          "meta_description" => "Page de création de compte",
          "data" => ["loginMessage" => $message]
        ];
      }

      // on vérifie que tout est correct à l'envoi

      // S'il manque un input
      if (!($pseudo && $email && $pass1 && $pass2)) {
        $message = "<p class='alertNotif'>Merci de renseigner tous les champs :)</p>";
        return redirectAndMessage($message);
      }

      // Si le mail est déja existant
      $userEmail = $userManager->findUserByEmail($email);
      if($userEmail) {
        $message = "<p class='alertNotif'>Votre email est déjà attribué a un compte. Allez à la page de <a href='index.php?ctrl=security&action=login'>connexion</a>.</p>";
        return redirectAndMessage($message);
      }

      // si le pseudo existe déja
      $userPseudo = $userManager->findUserByPseudo($pseudo);
      if($userPseudo) {
        $message = "<p class='alertNotif'>Le pseudo existe déja. Veuillez en choisir un autre.</p>";
        return redirectAndMessage($message);
      }
        
      // si le mot de passe n'est pas conforme
      if(strlen($pass1) <= 5) {
        $message = "<p class='alertNotif'>Saisissez un mot de passe de 6 caractères minimum.</p>";
        return redirectAndMessage($message);
      }

      // si les 2 mots de passe ne correspondent pas
      if($pass1 != $pass2) {
        $message = "<p class='alertNotif'>Les mots de passe ne correspondent pas</p>";
        return redirectAndMessage($message);
      }

      // Si tout est bon, on envoie
      $password = password_hash($pass1, PASSWORD_DEFAULT);
      
      $message = "<p class='addNotif'>Votre compte a été créé, vous pouvez maintenant vous connecter.</p>";
      
      $newUser = [
        "pseudo" => $pseudo,
        "email" => $email,
        "password" => $password,
      ];
      
      $userManager->add($newUser);
    Session::addFlash("success","compte créé avce succès");

      return [
        "view" => VIEW_DIR."login.php",
        "meta_description" => "Page de connexion au forum",
        "data" => ["message" => $message]
      ];

      // S'il n'y a aucun formulaire a traiter (on arrive seulement sur la page)
    } else {
      return [
        "view" => VIEW_DIR."register.php",
        "meta_description" => "Page de création de compte"
      ];
    }
  }

        //////////////////////////////////////////////
        /////////// TRAITEMENT D'UN LOGIN ////////////
        //////////////////////////////////////////////
  public function login () {
    if(isset($_POST["submit"])) {

      $userManager = new UserManager();

      $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      // fonction de redirection avec le message d'erreur
      function redirectAndMessage($message) { 
        return [
          "view" => VIEW_DIR."login.php",
          "meta_description" => "Page de création de compte",
          "data" => ["loginMessage" => $message]
        ];
      }

      // on vérifie que tout est correct à l'envoi

      // S'il manque un input
      if (!($pseudo && $password)) {
        $message = "<p class='alertNotif'>Merci de renseigner vos identifiants :)</p>";
        Session::addFlash("error","trololol");
        return redirectAndMessage($message);
      }

      // On vérifie que le pseudo existe et que les mots de passe correspondent
      $user = $userManager->findUserByPseudo($pseudo);

      // S'il ne trouve pas le pseudo
      if(!$user) {
        $message = "<p class='alertNotif'>Pseudo ou mot de passe incorrect. Veuillez réessayer.</p>";
        Session::addFlash("error","vérifiez vos identifiants");
        return redirectAndMessage($message);
      }

      $hach = $user->getPassword();
      
      // Si le mot de passe est faux
        if(!password_verify($password, $hach)) {
        Session::addFlash("error","vérifiez vos identifiants");
        $message = "<p class='alertNotif'>Pseudo ou mot de passe incorrect. Veuillez réessayer.</p>";
        return redirectAndMessage($message);
      }
      
      // // Si tout est bon, on connecte l'user + redirect Home
      Session::setUser($user);
    Session::addFlash("success","bonjour ".Session::getUser());

      AbstractController::redirectTo($ctrl = "home", $action = "index", $id = null);

      // S'il n'y a aucun formulaire a traiter (on arrive seulement sur la page)
    } else {
      return [
        "view" => VIEW_DIR."login.php",
        "meta_description" => "Page de connexion",
      ];
    }
  }
  
        /////////////////// LOGOUT ///////////////////
  public function logout () {
    Session::addFlash("error","au revoir ".Session::getUser());
    Session::setUser(null);
    AbstractController::redirectTo($ctrl = "home", $action = "index", $id = null);
  }
  
        //////////////// CHANGE EMAIL ////////////////
  public function changeEmail(){
    $newEmail = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $userManager = new UserManager();

    // on vérifie l'entrée de l'email
    if(!$newEmail) {
      Session::addFlash("error","veuillez saisir un email valide");
      AbstractController::redirectTo($ctrl = "forum", $action = "myInfos");
    }

    $verifyEmail = $userManager->findUserByEmail($newEmail);

    // on vérifié si l'email existe déja
    if($verifyEmail) {
      Session::addFlash("error","cet email a déjà été attribué");
      AbstractController::redirectTo($ctrl = "forum", $action = "myInfos");
    }
// on change l'email et on réattribue les données de l'user dans SESSION
    $userManager->changeEmail($newEmail);

    Session::addFlash("success","votre email a été modifié");

    $userUpdated = $userManager->findOneById(Session::getUser()->getId());
    Session::setUser($userUpdated);

    AbstractController::redirectTo($ctrl = "forum", $action = "myInfos");
  }

        ////////////// CHANGE PASSWORD //////////////
  public function changePassword() {
    $actualPass = filter_input(INPUT_POST, "actualPass", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $newPass1 = filter_input(INPUT_POST, "newPass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $newPass2 = filter_input(INPUT_POST, "newPass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $userManager = new UserManager();

    // on récupère l'user de la base de donnée. 
    // (on fait pas confiance à l'user de Session)
    $user = $userManager->findOneById(Session::getUser()->getId());
    $hach = $user->getPassword();

    if(!password_verify($actualPass, $hach)){
      Session::addFlash("error"," vérifiez votre mot de passe");
      AbstractController::redirectTo($ctrl = "forum", $action = "myInfos");
    }

    if($actualPass == $newPass1) {
      Session::addFlash("error","Choisissez un mot de passe différent");
      AbstractController::redirectTo($ctrl = "forum", $action = "myInfos");
    }

    if($newPass1 != $newPass2) {
      Session::addFlash("error"," les deux mots de passe ne sont pas identiques");
      AbstractController::redirectTo($ctrl = "forum", $action = "myInfos");
    }

    $newPassword = password_hash($newPass1, PASSWORD_DEFAULT);
    $userManager->changePassword($newPassword);
    Session::addFlash("success"," votre mot de passe a été mis à jour");
    
    $userUpdated = $userManager->findOneById(Session::getUser()->getId());
    Session::setUser($userUpdated);

    AbstractController::redirectTo($ctrl = "forum", $action = "myInfos");
  }

  //////////////// CHANGE AVATAR ////////////////
  public function changeAvatar(){

    $target_dir = PUBLIC_DIR."img/avatar/";
    // le nom du fichier est $_FILES["avatar"]["name"]
    // on veut rename le fichier pour qu'il soit unique :
    // on utilise uniqid()
    $original_fileName = $target_dir.basename($_FILES["avatar"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($original_fileName,PATHINFO_EXTENSION));
    $target_file = basename(uniqid().'.'.$imageFileType);
    
    if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["avatar"]["tmp_name"]);
      if($check !== false) {
        echo"File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } else {
        echo "File is not an image.";
        $uploadOk = 0;
      }
    }

    // si le fichier existe déja
    if (file_exists($target_dir.$target_file)) {
        Session::addFlash("error","Le fichier existe déjà, veuillez le renommer.");
      $uploadOk = 0;
    }
    
    // restriction de taille
    if ($_FILES["avatar"]["size"] > 500000) {
        Session::addFlash("error","Fichier trop volumineux.");
      $uploadOk = 0;
    }

    // restriction de format
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        Session::addFlash("error","Seulement JPG, JPEG, PNG & GIF autorisés.");
      $uploadOk = 0;
    }

    if ($uploadOk == 0) {
    // si tout est ok, on upload le fichier
    } else {
      if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_dir.$target_file)) {
        Session::addFlash("success","Vous avez un nouvel avatar!");
      } else {
        Session::addFlash("error","Désolé une erreur est survenue.");
      }
    }

    $userManager = new UserManager();
    // on change l'avatar de la BDD et on met a jour l'user de SESSION 
    $userManager->changeAvatar($target_file);

    $userUpdated = $userManager->findOneById(Session::getUser()->getId());
    Session::setUser($userUpdated);

    AbstractController::redirectTo($ctrl = "forum", $action = "myInfos");
  }
}