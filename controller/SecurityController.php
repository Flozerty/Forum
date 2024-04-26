<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\UserManager;

class SecurityController extends AbstractController{
  // contiendra les méthodes liées à l'authentification : register, login et logout

  public function register () {
    return [
      "view" => VIEW_DIR."register.php",
      "meta_description" => "Création de compte utilisateur",
      "data" => [
      ]
    ];
  }
  public function login () {
    return [
      "view" => VIEW_DIR."login.php",
      "meta_description" => "Page de connexion au forum",
      "data" => [
      ]
    ];
  }

  public function loginConfirmation(){
    $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);


    // $sql = "
    // SELECT *
    // FROM user a
    // WHERE user.pseudo = :pseudo
    // AND user.password = :pass
    // ";

    // DAO::execute(
    //   $sql, [
    //     'pseudo' => $pseudo,
    //     'pass' => $password
    //   ], false);
  
  }
  
  public function logout () {}

  
  
  public function traitement () {

    if(isset($_GET["type"])) {
      switch($_GET["type"]) {
        case "register" : 

          $userManager = new UserManager();
    
          $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $pass1 = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $pass2 = filter_input(INPUT_POST, "password2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
    
          if($pseudo && $email && $pass1 && $pass2) {
            
            $user = $userManager->findUserByEmail($email);
            
            if(!$user) {
              $message = "Votre compte a été créé, vous pouvez maintenant vous connecter.";
              return [
                "view" => VIEW_DIR."register.php",
                "meta_description" => "Page de connexion au forum",
                "data" => ["message" => $message]
              ];
            } else {
              $message = "Votre email est déjà attribué a un compte. Allez à la page de connexion.";

              return [
                "view" => VIEW_DIR."register.php",
                "meta_description" => "Page de connexion au forum",
                "data" => ["message" => $message]
              ];
            }

          }
    
          break;
        case "login" :

          break;
      }
    }
  }
}