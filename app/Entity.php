<?php
namespace App;

abstract class Entity{

  protected function hydrate($data){

    foreach($data as $field => $value){
      // field = topic_id
      // fieldarray = ['topic','id']
      $fieldArray = explode("_", $field);

      if(isset($fieldArray[1]) && $fieldArray[1] == "id"){
        // manName = TopicManager 
        $manName = ucfirst($fieldArray[0])."Manager";
        // FQCName = Model\Managers\TopicManager;
        $FQCName = "Model\Managers\\".$manName;

        // man = new Model\Managers\TopicManager
        $man = new $FQCName();
        // value = Model\Managers\TopicManager->findOneById(1)
        $value = $man->findOneById($value);
      }

      // fabrication du nom du setter à appeler (ex: setName)
      $method = "set".ucfirst($fieldArray[0]);

      // si setName est une méthode qui existe dans l'entité (this)
      if(method_exists($this, $method)){
        // $this->setName("valeur")
        $this->$method($value);
      }
    }
  }

  public function getClass(){
  return get_class($this);
  }

  // Fonction qui renvoie le délai depuis une date donnée.
  public function getTimeDelay($date){
    $timeDiff = time()-strtotime($date);
        switch (true){
          case($timeDiff <60):
            echo "$timeDiff secondes";break;
          case($timeDiff<3600):
            $minutes = round($timeDiff / 60);
            echo "$minutes minutes";break;
          case($timeDiff<3600*24):
            $hours = round($timeDiff / 3600);
            echo "$hours heures"; break;
          default:
          $jours = round($timeDiff / (3600*24));
            echo "$jours jours";break;
        }
  }
}