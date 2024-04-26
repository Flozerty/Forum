<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class UserManager extends Manager{

  // on indique la classe POO et la table correspondante en BDD pour le manager concerné
  protected $className = "Model\Entities\User";
  protected $tableName = "user";

  public function __construct(){
    parent::connect();
  }

  public function findUserByEmail($email) {
    $sql = "
    SELECT *
    FROM $this->tableName
    WHERE email = :email
    ";
    return $this->getOneOrNullResult(
      DAO::select($sql, ['email' => $email]), 
      $this->className
    );
  }

  public function findUserByPseudo($pseudo) {
    $sql = "
    SELECT *
    FROM $this->tableName
    WHERE pseudo = :pseudo
    ";
    return $this->getOneOrNullResult(
      DAO::select($sql, ['pseudo' => $pseudo], false), 
      $this->className
    );
  }
}