<?php
session_start();
include "inc/db.php";
include_once "lang.php";
if (empty($_SESSION['id_clien'])) {
  $profile = "login.php";
  $cpp="0";
} else {
  $profile = "profile.php";
  $req = $db->prepare("SELECT count(*) as cp from produit_panier where idc=? and statut='instance'");
  $req->execute([$_SESSION['id_clien']]);
  $cpp= $req->fetch()['cp'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Oummipharma</title>

  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="assets/images/logol.png" type="image/svg+xml">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="./assets/css/login.css">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- 
    - preload images
  -->
  <link rel="preload" as="image" href="./assets/images/logo.png">
  <link rel="preload" as="image" href="./assets/images/hero-banner-1.jpg">
  <link rel="preload" as="image" href="./assets/images/hero-banner-2.jpg">
  <link rel="preload" as="image" href="./assets/images/hero-banner-3.jpg">

</head>

<body id="top">

  <!-- 
    - #HEADER
  -->

  <header class="header">

    <div class="alert">
      <div class="container">
        <p class="alert-text">Livraison gratuite dans la ville d'Agadir</p>
      </div>
    </div>

    <div class="header-top" data-header>
      <div class="container">

        <button class="nav-open-btn" aria-label="open menu" data-nav-toggler>
          <span class="line line-1"></span>
          <span class="line line-2"></span>
          <span class="line line-3"></span>
        </button>

        <div class="input-wrapper">
          <input type="search" name="search" value="<?php if (isset($_GET['search'])) {
                                                      echo $_GET['nom'];
                                                    } ?>" placeholder="Search product" class="search-field" disabled>

          <a href="#produits" class="search-submit" aria-label="search" type="submit">
            <ion-icon name="search-outline" aria-hidden="true"></ion-icon>
          </a>
        </div>

        <a href="index.php" class="logo">
          <img src="./assets/images/logol.png" width="85" height="22" alt="Glowing">
        </a>

        <div class="header-actions">

          <a href="<?= $profile ?>" class="header-action-btn" aria-label="user">
            <ion-icon name="person-outline" aria-hidden="true" aria-hidden="true"></ion-icon>
          </a>

          <a href="pannier.php" class="header-action-btn" aria-label="cart item">

            <ion-icon name="bag-handle-outline" aria-hidden="true" aria-hidden="true"></ion-icon>

            <span class="btn-badge">
              <?= $cpp ?>
            </span>
          </a>

        </div>

        <nav class="navbar">
          <ul class="navbar-list">

            <li>
              <a href="index.php#home" class="navbar-link has-after">Home</a>
            </li>

            <li>
              <a href="index#collection" class="navbar-link has-after">Collection</a>
            </li>

            <li>
              <a href="index#produits" class="navbar-link has-after">Produits</a>
            </li>

            <li>
              <a href="index#offer" class="navbar-link has-after">Offer</a>
            </li>

            <li>
              <a href="index#blog" class="navbar-link has-after">Blog</a>
            </li>

          </ul>
        </nav>

      </div>
    </div>

  </header>





  <!-- 
    - #MOBILE NAVBAR
  -->

  <div class="sidebar">
    <div class="mobile-navbar" data-navbar>

      <div class="wrapper">
        <a href="#" class="logo">
          <img src="./assets/images/logol.png" width="179" height="26" alt="Glowing">
        </a>

        <button class="nav-close-btn" aria-label="close menu" data-nav-toggler>
          <ion-icon name="close-outline" aria-hidden="true"></ion-icon>
        </button>
      </div>

      <ul class="navbar-list">

        <li>
          <a href="index#home" class="navbar-link" data-nav-link>Home</a>
        </li>

        <li>
          <a href="index#collection" class="navbar-link" data-nav-link>Collection</a>
        </li>

        <li>
          <a href="index#produits" class="navbar-link" data-nav-link>Produits</a>
        </li>

        <li>
          <a href="index#offer" class="navbar-link" data-nav-link>Offer</a>
        </li>

        <li>
          <a href="index#blog" class="navbar-link" data-nav-link>Blog</a>
        </li>
        <li>
          <a href="pannier.php" class="header-action-btn" aria-label="cart item">

            <span class="btn-badge">
              Panier
              <?= $cpp ?>
            </span>
          </a>
        </li>

      </ul>

    </div>

    <div class="overlay" data-nav-toggler data-overlay></div>
  </div>





<?php 
  $sql = $db->prepare("SELECT * from clien where id=?");
  $sql->execute([$_SESSION['id_clien']]);
  $tab = $sql->fetch();
  if (isset($_POST['nomCmplet'])) {
    $req = $db->prepare("UPDATE clien set nom =?  where id=? ");
    $req->execute([$_POST['firstName'], $_SESSION['id_clien']]);
    echo '<meta http-equiv="refresh" content="0">';
  }

  if (isset($_POST['vemail'])) {
    $req = $db->prepare("UPDATE clien set email =?  where id=? ");
    $req->execute([$_POST['email'], $_SESSION['id_clien']]);
    echo '<meta http-equiv="refresh" content="0">';
  }

  if (isset($_POST['mpass'])) {
    $req = $db->prepare("UPDATE clien set passworde =?  where id=? ");
    $pass = $db->prepare("SELECT count(*) c from clien where passworde=? and id =?");
    $pass->execute([$_POST['ap'], $_SESSION['id_clien']]);
    $pp = $pass->fetch();
    if ($pp['c'] != 0) {
      if ($_POST['np'] == $_POST['cp']) {
        $req->execute([$_POST['cp'], $_SESSION['id_clien']]);
        echo "<div class='alert alert-success' role='alert'>Le mot de passe a été changé avec succès</div>";
      } else {
        echo "<div class='alert alert-danger' role='alert'>Erreur de Confirmation mot de passe!</div>";
      }
    } else {
      echo "<div class='alert alert-danger' role='alert'>Erreur de mot de passe!</div>";
    }
  }

  if (isset($_POST['Mtel'])) {
    $TEL=$_POST['tel'];

    $req = $db->prepare("UPDATE clien set tel =?  where id=? ");
    $req->execute([$TEL, $_SESSION['id_clien']]);
    echo '<meta http-equiv="refresh" content="0">';
  }
  if(isset($_POST['deconnecter'])){
    session_unset();
    echo "<script>window.location='index.php';</script>";
  }

  ?>
  <section class="profil">
    <div>
      <form action="" method="post" id="" class="deconnect">
        <input type="submit" class="btn btn-primary" name="deconnecter" value="Se déconnecter">
      </form>
    </div>
    <div>
      

      <form class="was-validated" action="" id="formContent" method="POST">
        <div class="mb-3 row">
          <input type="text" class="fadeIn second" id="validationTextarea" name="firstName" value="<?= $tab['nom'] ?>" required>
          <input type="submit" class="btn btn-primary col-2" name="nomCmplet" value="Modifier nom">
        </div>
      </form><br>

      <form class="was-validated" action="" id="formContent" method="POST">
        <div class="mb-3 row">
          <input type="email" class="form-control is-invalid col" id="validationTextarea" name="email" value="<?= $tab['email'] ?>" required>
          <input type="submit" class="btn btn-primary  col-2" value="Modifier email" name="vemail">
        </div>
      </form><br>


      <form class="" action="" id="formContent" method="POST">
        <div class="mb-3 row">
          <input type="password" name="ap" class="form-control  col" id="" value="" required placeholder="ancien mot de passe">

        </div>
        <div class="mb-3 row">
          <input type="password" name="np" class="form-control  col" id="" value="" required placeholder="nouveau mot de passe">

        </div>
        <div class="mb-3 row">
          <input type="password" name="cp" class="" id="" value="" required placeholder="Confirmation mot de passe">
          <input type="submit" name="mpass" class="btn btn-primary col-2" value="Modifier mot de pass">
        </div>
      </form><br>
      <form class="was-validated" action="" id="formContent" method="POST">
        <div class="mb-3 row">
          <input type="text" class="fadeIn second" id="validationTextarea" name="tel" value="<?= $tab['tel'] ?>" required>
          <input type="submit" class="btn btn-primary col-2" name="Mtel" value="Modifier tel">
        </div>
      </form>



    </div>
  </section>










  <!-- 
    - #FOOTER
  -->

  <footer class="footer" data-section>
    <div class="container">

      <div class="footer-top">

        <h1 class="nom">Bienvenue à Oummipharma</h1>

      </div>

      <div class="footer-bottom">
        <div class="wrapper">
          <p class="copyright">
            &copy; 2023 Oummipharma 
          </p>

          <ul class="social-list">

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-twitter"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-facebook"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-instagram"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-youtube"></ion-icon>
              </a>
            </li>

          </ul>
        </div>

      </div>

    </div>
  </footer>





  <!-- 
    - #BACK TO TOP
  -->

  <a href="#top" class="back-top-btn" aria-label="back to top" data-back-top-btn>
    <ion-icon name="arrow-up" aria-hidden="true"></ion-icon>
  </a>





  <!-- 
    - custom js link
  -->
  <script src="./assets/js/script.js" defer></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>