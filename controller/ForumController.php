<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;
use Model\Managers\UserManager;

class ForumController extends AbstractController implements ControllerInterface {

  public function index() {
    $categoryManager = new CategoryManager();
    $postManager = new PostManager();
    $categories = $categoryManager->findAll();

    $activesAllTime = $postManager->activesAllTime();
    $activesWeek = $postManager->activesWeek();
    return [
      "view" => VIEW_DIR."home.php",
      "meta_description" => "Page d'accueil du forum",
      "data" => [
        "categories" => $categories,
        "activesAllTime"=> $activesAllTime,
        "activesWeek"=> $activesWeek,
      ]
    ];
  }

  public function listCategories() {

    $categoryManager = new CategoryManager();
    $categories = $categoryManager->findAll();
    $listCategories = $categoryManager->findAll(["name"]);

    return [
      "view" => VIEW_DIR."forum/listCategories.php",
      "meta_description" => "Liste des catégories : ",
      "data" => [
        "categories" => $categories,
        "listCategories" => $listCategories
      ]
    ];
  }

  public function listTopicsByCategory($id) {

    $topicManager = new TopicManager();
    $categoryManager = new CategoryManager();
    $categories = $categoryManager->findAll();
    $category = $categoryManager->findOneById($id);
    $topics = $topicManager->findTopicsByCategory($id);

    return [
      "view" => VIEW_DIR."forum/listTopics.php",
      "meta_description" => "Liste des topics par catégorie : " . $category,
      "data" => [
        "categories" => $categories,
        "category" => $category,
        "topics" => $topics
      ]
    ];
  }

  public function topicContent($id) {

    $topicManager = new TopicManager();
    $categoryManager = new CategoryManager();
    $postManager = new PostManager();
    $categories = $categoryManager->findAll();
    $topic = $topicManager->findOneById($id);
    $posts = $postManager->findPostsByTopic($id);

    return [
      "view" => VIEW_DIR."forum/topicContent.php",
      "meta_description" => $topic,
      "data" => [
        "categories" => $categories,
        "topic" => $topic,
        "posts" => $posts
      ]
    ];
  }

  public function addTopic($idCategory) {
    $topicManager = new TopicManager();

    $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $intro = filter_input(INPUT_POST, "newtopicIntro", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $userId = Session::getUser()->getId();

    $topicManager->add([
      "title" => $title,
      "intro" => $intro,
      "category_id" => $idCategory,
      "user_id" => $userId
    ]);
    AbstractController::redirectTo($ctrl = "forum", $action = "listTopicsByCategory", $id = $idCategory);
  }
  public function createCategory() {
    $categoryManager = new CategoryManager();

    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $icone = filter_input(INPUT_POST, "icone", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $categoryManager->add([
      "name" => $name,
      "icone" => $icone
    ]);
    AbstractController::redirectTo($ctrl = "forum", $action = "listCategories");
  }
}