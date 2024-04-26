<?php
if(isset($result["data"]['categories'])) {
  $categories = $result["data"]['categories']; 
}
  $activePage = filter_input(INPUT_GET, "action", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
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

          <?php if(App\Session::isAdmin()) { ?>
          <a href="index.php?ctrl=home&action=users">Voir la liste des gens</a>
          <?php } ?>

          <div id="search">
            <img src="public/img/wenSearch.png" alt="image loupe de la barre de recherche">
            <input type="search" placeholder="recherchez un topic, une catégorie">
          </div>

          <div id="nav-right">

            <!-- si l'utilisateur est connecté  -->
            <?php if(App\Session::getUser()){ ?>

            <a href="index.php?ctrl=security&action=profile"><span
                class="fas fa-user"></span>&nbsp;<?= App\Session::getUser()?></a>
            <a href="index.php?ctrl=security&action=logout">Déconnexion</a>

            <?php } else { ?>

            <a href="index.php?ctrl=security&action=register">Inscription</a>
            <a href="index.php?ctrl=security&action=login">Connexion</a>

            <?php } ?>
          </div>
        </nav>
      </header>

      <main id="forum">

        <!-------------------------------------------->
        <!---------------- side-left ----------------->
        <!-------------------------------------------->

        <!-- sauf quand login / register -->
        <?php if($activePage != "login" && $activePage != "register" && $activePage != "traitement") { ?>

        <div id="sideNav-left">
          <nav>
            <p>
              <a href="index.php">Accueil</a>
            </p>
            <div id="sideBar-categories">
              <p>
                <a href="index.php?ctrl=forum&action=listCategories">THÉMATIQUES :</a>
              </p>

              <!-- Liste des catégories -->
              <div id="categoriesListContainer">
                <div id="hrBar"></div>
                <ul id="nav-links">

                  <?php foreach($categories as $category) { ?>
                  <li class="nav-link">
                    <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>">
                      <div id="categoryIcone"><?= $category->getIcone() ?></div>
                      <?= $category->getName() ?>
                    </a>
                  </li>
                  <?php } ?>

                </ul>
              </div>
            </div>
          </nav>

          <!-- Activité de la communauté -->
          <div id="community-activity">activity</div>
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
        <?php if($activePage != "login" && $activePage != "register" && $activePage != "traitement") { ?>

        <aside id="layout-aside">
          <div id="myActives">
            My actives
          </div>
          aside
          <div id="poll">Poll</div>
        </aside>
        <?php } ?>
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

  <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"
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
  </script> -->
  <script src="<?= PUBLIC_DIR ?>/js/script.js"></script>
</body>

</html>