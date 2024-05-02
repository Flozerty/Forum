<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class TopicManager extends Manager {

  // on indique la classe POO et la table correspondante en BDD pour le manager concerné
  protected $className = "Model\Entities\Topic";
  protected $tableName = "topic";

  public function __construct() {
    parent::connect();
  }

  // récupérer tous les topics d'une catégorie spécifique (par son id)
  public function findTopicsByCategory($id) {

    $sql = "
    SELECT *, DATE_FORMAT(creationDate, '%d/%m/%Y') AS creationDate
    FROM ".$this->tableName." t 
    WHERE t.category_id = :id";

    // la requête renvoie plusieurs enregistrements --> getMultipleResults
    return  $this->getMultipleResults(
      DAO::select($sql, ['id' => $id]), 
      $this->className
    );
  }
  
  public function findTopicUser($id) {
    $sql = "
    SELECT * 
    FROM user
    WHERE user.category_id = :id";

    // la requête renvoie plusieurs enregistrements --> getMultipleResults
    return  $this->getMultipleResults(
      DAO::select($sql, ['id' => $id]), 
      $this->className
    );
  }

  public function popularTopics() {
 
    $sql = "
    SELECT id_topic, title, pseudo AS user, DATE_FORMAT(creationDate, '%d/%m/%Y') AS creationDate, COUNT(post.topic_id) AS nbPosts
    FROM $this->tableName
    LEFT JOIN post ON post.topic_id = topic.id_topic
    INNER JOIN user ON user.id_user = topic.user_id
    GROUP BY topic.id_topic
    ORDER BY nbPosts DESC
    LIMIT 5
    ";

    return $this->getMultipleResults(
      DAO::select($sql), 
      $this->className
    );
  }

  public function lastTopics() {
 
    $sql = "
    SELECT *, pseudo AS user, DATE_FORMAT(creationDate, '%d/%m/%Y') AS creationDate
    FROM $this->tableName
    INNER JOIN user ON user.id_user = topic.user_id
    ORDER BY topic.creationDate DESC
    LIMIT 5
    ";

    return $this->getMultipleResults(
      DAO::select($sql),
      $this->className
    );
  }
  
  public function lastTopicsPosts() {
    // $sql= "
    // SELECT DISTINCT id_post, topic.title, postDate, messageContent, post.user_id, pseudo
    // FROM topic
    // LEFT JOIN post ON post.topic_id = topic.id_topic
    // LEFT JOIN user ON user.id_user = post.user_id
    // ORDER BY postDate DESC
    // WHERE
    // " ;
  }
}