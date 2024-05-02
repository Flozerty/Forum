<?php
namespace Model\Entities;
use App\Entity;

/*
  En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class User extends Entity{

  private $id;
  private $pseudo;
  private $email;
  private $password;
  private $inscriptionDate;
  private $role;
  private $avatar;
  private $nbPosts;

  public function __construct($data){         
    $this->hydrate($data);        
  }

  /////////// GETTERS & SETTERS ///////////
  public function getId(){
    return $this->id;
  }

  public function setId($id){
    $this->id = $id;
    return $this;
  }

  public function getPseudo(){
    return $this->pseudo;
  }

  public function setPseudo($pseudo){
    $this->pseudo = $pseudo;
    return $this;
  }
  public function getRole()
  {
    return $this->role;
  }
  public function setRole($role)
  {
    $this->role = $role;
    return $this;
  }
  public function getAvatar()
  {
    return $this->avatar;
  }
  public function setAvatar($avatar)
  {
    $this->avatar = $avatar;
    return $this;
  } 
  public function getInscriptionDate()
  {
    return $this->inscriptionDate;
  }
  public function setInscriptionDate($inscriptionDate)
  {
    $this->inscriptionDate = $inscriptionDate;
    return $this;
  } 
  public function getPassword()
  {
    return $this->password;
  }
  public function setPassword($password)
  {
    $this->password = $password;
    return $this;
  }
  public function getEmail()
  {
    return $this->email;
  }
  public function setEmail($email)
  {
    $this->email = $email;
    return $this;
  }
  public function getNbPosts()
  {
    return $this->nbPosts;
  }
  public function setNbPosts($nbPosts)
  {
    $this->nbPosts = $nbPosts;
  }
///////////////////////////////////////////////

  public function __toString() {
    return $this->pseudo;
  }

  public function hasRole($role) {
    if($this->role === $role) {
      return true;
    } else {
      return false;
    }
  }


}