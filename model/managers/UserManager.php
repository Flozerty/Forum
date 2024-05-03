<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;
use App\Session;

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

  // return les user qui ont fait le plus de posts (1 week)
  public function activesWeek() {
    $sql= "
    SELECT id_user, user.pseudo, COUNT(*) AS nbPosts
    FROM $this->tableName
    INNER JOIN post ON post.user_id = user.id_user
    WHERE postDate > DATE_SUB(CURDATE(), INTERVAL 7 DAY)
    GROUP BY id_user
    ORDER BY nbPosts DESC 
    LIMIT 5
    ";
    return $this->getMultipleResults(
      DAO::select($sql), 
      $this->className);
  }
  // DATE_SUB(CURDATE(), INTERVAL 7 DAY) : 
  // On peut DATE_SUB et DATE_ADD


  // return les user qui ont fait le plus de posts (tout le temps)
  public function activesAllTime() {
    $sql= "
    SELECT id_user, user.pseudo, COUNT(*) AS nbPosts
    FROM $this->tableName
    INNER JOIN post ON post.user_id = user.id_user
    GROUP BY id_user
    ORDER BY nbPosts DESC 
    LIMIT 5
    ";
    return $this->getMultipleResults(
      DAO::select($sql), 
      $this->className);
  }

  // return les topics actifs de l'user connecté
  public function myActivesTopics() {

    // je peux utiliser Session ici?
    $user = Session::getUser();
    $id = $user->getId();

    $sql= "
    SELECT pseudo, title, id_topic, intro, post.user_id
    FROM $this->tableName
    INNER JOIN post ON post.user_id = user.id_user
    INNER JOIN topic ON topic.user_id = user.id_user
    
    WHERE post.user_id = :id
    GROUP BY id_topic
    ";
    return $this->getMultipleResults(
      DAO::select($sql, ['id' => $id]), 
      $this->className);
  }
}