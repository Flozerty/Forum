<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;

class SecurityController extends AbstractController{
  // contiendra les méthodes liées à l'authentification : register, login et logout

  public function register () {}
  public function login () {}

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
}