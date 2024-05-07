<?php
$activePage = filter_input(INPUT_GET, "action", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

use App\Session;

if(isset($result["data"]['categories'])) {
  $categories = $result["data"]['categories']; 
}
if(isset($result["data"]['activesAllTime'])) {
  $activesAllTime = $result["data"]['activesAllTime']; 
}
if(isset($result["data"]['activesWeek'])) {
  $activesWeek = $result["data"]['activesWeek']; 
}
if(isset($result["data"]['myActivesTopics'])) {
  $myActivesTopics = $result["data"]['myActivesTopics']; 
}
if(isset($result["data"]['myTopics'])) {
  $myTopics = $result["data"]['myTopics']; 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= $meta_description ?>">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- <script src="https://cdn.tiny.cloud/1/zg3mwraazn1b2ezih16je1tc6z7gwp5yd4pod06ae5uai8pa/tinymce/5/tinymce.min.js"
    referrerpolicy="origin"></script> -->

  <script src="https://kit.fontawesome.com/7252ea4d54.js" crossorigin="anonymous"></script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cabin:ital,wght@0,400..700;1,400..700&display=swap"
    rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
    integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />

  <link rel="stylesheet" href="<?= PUBLIC_DIR ?>css/style.css">
  <title>FORUM</title>
</head>

<body>
  <div id="wrapper">
    <div id="mainpage">
      <!-- c'est ici que les messages (erreur ou succès) s'affichent-->
      <h3 class="message" style="color: red"><?= App\Session::getFlash("error") ?></h3>
      <h3 class="message" style="color: green"><?= App\Session::getFlash("success") ?></h3>

      <!-------------------------------------------->
      <!------------------ header ------------------>
      <!-------------------------------------------->
      <header>
        <nav>
          <div id="logo-container">
            <a href="index.php">
              <figure id="logo-figure">
                <img src="public/img/logoblue.png" alt="logo de Forum">
                <figcaption>
                  Forum
                </figcaption>
              </figure>
            </a>
          </div>

          <div id="search">
            <img src="public/img/wenSearch.png" alt="image loupe de la barre de recherche">
            <input type="search" placeholder="recherchez un topic, une catégorie">
          </div>

          <div id="nav-right">

            <!-- si l'utilisateur est connecté  -->
            <?php if(Session::getUser()){ ?>

            <!-- profil -->
            <div id=userContainer>
              <figure id="userFigureContainer">
                <img src="<?= PUBLIC_DIR."img/avatar/".App\Session::getUser()->getAvatar() ?>"
                  alt="avatar de <?= App\Session::getUser()?>">
                <figcaption><?= App\Session::getUser()?></figcaption>
              </figure>
              <i id="userPanelShow" class="fa-solid fa-caret-down"></i>
            </div>

            <!-- fonctionnalités connecté -->
            <ul id="headerNavList">
              <li class="link"><a href="index.php?ctrl=security&action=logout">Déconnexion</a></li>
              <li class="link"><a href="index.php">Messagerie</a></li>
              <li class="link"><a href="index.php?ctrl=forum&action=myInfos">Mes informations</a></li>
              <li class="link"><a href="index.php">Mode sombre</a></li>

              <!-- ++ si l'utilisateur est admin -->

              <?php if(Session::isAdmin()) { ?>
              <li class="link"><a href="index.php?ctrl=home&action=users">Voir la liste des gens</a></li>
              <li class="link"><a href="index.php?ctrl=forum&action=listCategories">Voir la liste des catégories</a>
              </li>
              <?php } ?>

            </ul>

            <!-- si l'utilisateur n'est pas connecté -->
            <?php } else { ?>

            <p><a href="index.php?ctrl=security&action=register">Inscription</a></p>
            <p><a href="index.php?ctrl=security&action=login">Connexion</a></p>

            <?php } ?>
          </div>
        </nav>
      </header>

      <main id="forum">

        <!-------------------------------------------->
        <!---------------- side-left ----------------->
        <!-------------------------------------------->

        <!-- sauf quand login / register -->
        <?php if($activePage != "login" && $activePage != "register") { ?>

        <div id="sideNav-left">
          <i id="toggle-left" class="toggleButton fa-solid fa-circle-arrow-right"></i>
          <nav>
            <p class="link">
              <a href="index.php">Accueil</a>
            </p>
            <div id="sideBar-categories">
              <p>
                THÉMATIQUES :
              </p>

              <!-- Liste des catégories -->
              <div id="categoriesListContainer">
                <div class="hrBar"></div>
                <ul id="nav-links">

                  <?php foreach($categories as $category) { ?>
                  <li class="nav-link">
                    <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>">
                      <span class="categoryIcone"><?= $category->getIcone() ?></span>
                      <p class="link"><?= $category->getName() ?></p>
                    </a>
                  </li>
                  <?php } ?>

                </ul>
              </div>
            </div>
          </nav>

          <!-- Activité de la communauté -->
          <section id="community-activity">
            <div id="activesAllTime">

              <p class="activesTitle"><b>Actifs depuis toujours :</b></p>

              <?php foreach($activesAllTime as $active) {
                echo "<p>".$active->getPseudo()." :<span>".$active->getNbPosts()."</span></p>";
              }?>
            </div>
            <div id="activesWeek">
              <p class="activesTitle">
                <b>Cette semaine :</b>
              </p>

              <?php foreach($activesWeek as $active) {
                echo "<p>".$active->getPseudo()." :<span>".$active->getNbPosts()."</span></p>";
              }?>
            </div>
          </section>
        </div>
        <?php } ?>

        <div id="main-wrapper">
          <!-------------------------- insertion -------------------------->
          <?= $page ?>
        </div>

        <!-------------------------------------------->
        <!---------------- side-right ---------------->
        <!-------------------------------------------->

        <!-- sauf quand login / register -->
        <?php 
        if($activePage != "login" && $activePage != "register" && Session::getUser()) { 
          ?>

        <aside id="layout-aside">
          <i id="toggle-right" class="toggleButton fa-solid fa-circle-arrow-left"></i>

          <!-- Les topics de l'user -->
          <?php if(isset($myTopics)) { ?>

          <div id="myTopics">
            <p>Mes sujets :</p>
            <div class="myTopicsList">
              <div class="hrBar"></div>
              <ul>

                <?php foreach($myTopics as $topic) { ?>
                <li class="nav-link link">
                  <a href="index.php?ctrl=forum&action=topicContent&id=<?= $topic->getId() ?>">
                    <?= $topic->getTitle() ?>
                  </a>
                </li>
                <?php } ?>

              </ul>
            </div>
          </div>
          <?php } ?>

          <!-- Les topics où l'user participe -->
          <?php 
          if(isset($myActivesTopics)) { 
            ?>

          <div id="myActives">
            <p>Mes discussions actives :</p>
            <div class="myTopicsList">
              <div class="hrBar"></div>
              <ul>

                <?php foreach($myActivesTopics as $topic) { ?>
                <li class="nav-link link">
                  <a href="index.php?ctrl=forum&action=topicContent&id=<?= $topic->getId() ?>">
                    <?= $topic->getTitle() ?>
                  </a>
                </li>
                <?php } ?>

              </ul>
            </div>
          </div>
          <?php } ?>

          <!-- Question de la semaine -->
          <div id="poll">Poll</div>

        </aside>
        <?php 
      } 
      ?>
      </main>
    </div>

    <!-------------------------------------------->
    <!------------------ footer ------------------>
    <!-------------------------------------------->
    <footer>
      <div id="footer-content">
        <div id="contact">
          <p>Contactez-moi</p>
          <ul>
            <li>
              <a href="#">
                <i class="fa-brands fa-facebook"></i>
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa-brands fa-instagram"></i>
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa-brands fa-linkedin"></i>
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa-brands fa-x-twitter"></i>
              </a>
            </li>
          </ul>
        </div>

        <div id="rules">
          <p>
            <a href="#">Règlement du forum</a>
          </p>
          <p>
            <a href="#">Mentions légales</a>
          </p>
        </div>
      </div>

      <p>&copy; <?= date_create("now")->format("Y") ?> - Flozerty</p>
    </footer>
  </div>

  <script src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous">
  </script>
  <script>
  $(document).ready(function() {
    $(".message").each(function() {
      if ($(this).text().length > 0) {
        $(this).slideDown(500, function() {
          $(this).delay(3000).slideUp(500)
        })
      }
    })
    $(".delete-btn").on("click", function() {
      return confirm("Etes-vous sûr de vouloir supprimer?")
    })
    tinymce.init({
      selector: '.post',
      menubar: false,
      plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount'
      ],
      toolbar: 'undo redo | formatselect | ' +
        'bold italic backcolor | alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'removeformat | help',
      content_css: '//www.tiny.cloud/css/codepen.min.css'
    });
  })
  </script>
  <script src="<?= PUBLIC_DIR ?>/js/createForm.js"></script>
  <script src="<?= PUBLIC_DIR ?>/js/userPanel.js"></script>
  <script src="<?= PUBLIC_DIR ?>/js/notif.js"></script>
  <script src="<?= PUBLIC_DIR ?>/js/myInfos.js"></script>
  <script src="<?= PUBLIC_DIR ?>/js/sideBars.js"></script>
</body>

</html>