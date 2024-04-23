<?php
namespace App;

// Création de constantes accessibles dans tout le projet :

define('DS', DIRECTORY_SEPARATOR); // le caractère séparateur de dossier (/ ou \)
// meilleure portabilité sur les différents systêmes.
define('BASE_DIR', dirname(__FILE__).DS);
define('VIEW_DIR', BASE_DIR."view/"); //le chemin où se trouvent les vues
define('PUBLIC_DIR', "public/");

define('DEFAULT_CTRL', 'Home');
define('ADMIN_MAIL', "admin@gmail.com");

require("app/Autoloader.php");

Autoloader::register();

session_start();
//et on intègre la classe Session qui prend la main sur les messages en session
use App\Session as Session;

//---------REQUETE HTTP INTERCEPTEE-----------
$ctrlname = DEFAULT_CTRL;
// index.php?ctrl=home
if(isset($_GET['ctrl'])) {
  $ctrlname = $_GET['ctrl'];
}

//on construit le namespace de la classe Controller à appeller
$ctrlNS = "controller\\".ucfirst($ctrlname)."Controller";

//on vérifie que le namespace pointe vers une classe qui existe
if(!class_exists($ctrlNS)) {
  //si c'est pas le cas, on choisit le namespace du controller par défaut
  $ctrlNS = "controller\\".DEFAULT_CTRL."Controller";
}

$ctrl = new $ctrlNS();

$action = "index"; //action par défaut de n'importe quel contrôleur

//si l'action est présente dans l'url ET que la méthode correspondante existe dans le ctrl
if(isset($_GET['action']) && method_exists($ctrl, $_GET['action'])) {
  //la méthode à appeller sera celle de l'url
  $action = $_GET['action'];
}

if(isset($_GET['id'])) {
  $id = $_GET['id'];

} else $id = null;

//ex : HomeController->users(null)
$result = $ctrl->$action($id);

/*--------CHARGEMENT PAGE--------*/
if ($action == "ajax") { //si l'action était ajax
  //on affiche directement le return du contrôleur (càd la réponse HTTP sera uniquement celle-ci)
  echo $result;

} else {

  ob_start();//démarre un buffer (tampon de sortie)

  $meta_description = $result['meta_description'];
  include($result['view']);

  $page = ob_get_contents();
  ob_end_clean();

  include VIEW_DIR."layout.php";
}