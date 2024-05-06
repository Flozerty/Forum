<?php
namespace Model\Entities;
use App\Entity;

final class Post extends Entity {
  private $id;
  private $postDate;
  private $messageContent;
  private $user;
  private $topic;
  private $deleted;

  public function __construct($data) {
    $this->hydrate($data);
  }

  /////////// GETTERS & SETTERS ///////////
  public function getId()
  {
    return $this->id;
  }
  public function setId($id)
  {
    $this->id = $id;
    return $this;
  }
  public function getTopic()
  {
    return $this->topic;
  }
  public function setTopic($topic)
  {
    $this->topic = $topic;
    return $this;
  }
  public function getUser()
  {
    return $this->user;
  }
  public function setUser($user)
  {
    $this->user = $user;
    return $this;
  }
  public function getMessageContent()
  {
    return $this->messageContent;
  }
  public function setMessageContent($messageContent)
  {
    $this->messageContent = $messageContent;
    return $this;
  }
  public function getPostDate()
  {
    return $this->postDate;
  }
  public function setPostDate($postDate)
  {
    $this->postDate = $postDate;
    return $this;
  }
  public function getDeleted()
  {
    return $this->deleted;
  }
  public function setDeleted($deleted)
  {
    $this->deleted = $deleted;
    return $this;
  }
  ///////////////////////////////////////////

  public function __toString(){
    return $this->messageContent;
  }

}