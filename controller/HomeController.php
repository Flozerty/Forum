<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use App\Session;
use Model\Managers\CategoryManager;
use Model\Managers\PostManager;
use Model\Managers\TopicManager;
use Model\Managers\UserManager;

class HomeController extends AbstractController implements ControllerInterface {

  public function index() {
    $topicManager = new TopicManager();
    $categoryManager = new CategoryManager();
    $userManager = new UserManager();
    $categories = $categoryManager->findAll();
    $popularTopics = $topicManager->popularTopics();
    $lastTopics = $topicManager->lastTopics();

    $activesAllTime = $userManager->activesAllTime();
    $activesWeek = $userManager->activesWeek();

    $myActivesTopics = (Session::getUser() ? $userManager->myActivesTopics() : null);
    
    return [
      "view" => VIEW_DIR."home.php",
      "meta_description" => "Page d'accueil du forum",
      "data" => [
        "categories" => $categories,
        "popularTopics"=> $popularTopics,
        "lastTopics" => $lastTopics,
        "activesAllTime"=> $activesAllTime,
        "activesWeek"=> $activesWeek,
        "myActivesTopics" => $myActivesTopics,
      ]
    ];
  }

  public function users() {
    $this->restrictTo("ROLE_USER");

    $manager = new UserManager();
    $users = $manager->findAll(['register_date', 'DESC']);

    return [
      "view" => VIEW_DIR."security/users.php",
      "meta_description" => "Liste des utilisateurs du forum",
      "data" => [ 
        "users" => $users 
      ]
    ];
  }
}