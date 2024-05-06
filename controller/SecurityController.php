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
  
        //////////////////////////////////////////////
        /////////////////// LOGOUT ///////////////////
        //////////////////////////////////////////////
  public function logout () {
    Session::addFlash("error","au revoir ".Session::getUser());
    $_SESSION["user"] = null;
    AbstractController::redirectTo($ctrl = "home", $action = "index", $id = null);
  }
  
}