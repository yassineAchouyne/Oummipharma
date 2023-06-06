<?php
session_start();

include_once "inc/db.php";
include_once "inc/lang.php";
if (empty($_SESSION['id_clien'])) {
  $profile = "login.php";
  $cpp = "0";
} else {
  $profile = "profile.php";
  $req = $db->prepare("SELECT count(*) as cp from produit_panier where idc=? and statut='instance'");
  $req->execute([$_SESSION['id_clien']]);
  $cpp = $req->fetch()['cp'];
}

if (!empty($_GET['lang'])) {
  if ($_GET['lang'] == 'ar') {
    $_SESSION['lang'] = "ar";
    echo '<script>location.href="index.php"</script>';
  } elseif ($_GET['lang'] == 'fr') {
    $_SESSION['lang'] = "fr";
    echo '<script>location.href="index.php"</script>';
  }
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

  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script  integrity="filehash" src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

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
        <p class="alert-text"><?= $titre ?></p>
      </div>
    </div>

    <div class="header-top" data-header>
      <div class="container">

        <button class="nav-open-btn" aria-label="open menu" data-nav-toggler>
          <span class="line line-1"></span>
          <span class="line line-2"></span>
          <span class="line line-3"></span>
        </button>

        <form class="input-wrappere" method="get" action="#produits">
          <input type="search" name="nom" placeholder="Search product" class="search-field">

          <button class="search-submit" aria-label="search" name="search" value="o" type="submit">
            <ion-icon name="search-outline" aria-hidden="true"></ion-icon>
          </button>
        </form>


        <a href="index.php" class="logo">
          <img src="./assets/images/logol.png" width="85" height="22" alt="Glowing">
        </a>

        <div class="header-actions">
          <a href="<?= $lien ?>" class="header-action-btn" aria-label="cart item">

            <img src="<?= $img ?>" width="30" height="30" alt="">
          </a>

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
              <a href="#home" class="navbar-link has-after"><?= $home ?></a>
            </li>

            <li>
              <a href="#collection" class="navbar-link has-after"><?= $collection ?></a>
            </li>

            <li>
              <a href="#produits" class="navbar-link has-after"><?= $pr ?></a>
            </li>

            <li>
              <a href="#offer" class="navbar-link has-after"><?= $offre ?></a>
            </li>

            <li>
              <a href="#blog" class="navbar-link has-after"><?= $blog ?></a>
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
          <a href="#home" class="navbar-link" data-nav-link><?= $home ?></a>
        </li>

        <li>
          <a href="#collection" class="navbar-link" data-nav-link><?= $collection ?></a>
        </li>

        <li>
          <a href="#produits" class="navbar-link" data-nav-link><?= $pr ?></a>
        </li>

        <li>
          <a href="#offer" class="navbar-link" data-nav-link><?= $offre ?></a>
        </li>

        <li>
          <a href="#blog" class="navbar-link" data-nav-link><?= $blog ?></a>
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





  <main>
    <article>

      <!-- 
        - #HERO
      -->

      <section class="section hero" id="home" aria-label="hero" data-section>
        <div class="container">

          <ul class="has-scrollbar">
            <?php
            $req = $db->prepare("SELECT photo FROM fhome limit 3");
            $req->execute();
            $row = $req->fetchAll();

            $sql = $db->prepare("SELECT min(prix) as min from product");
            $sql->execute();
            $min = $sql->fetch()['min'];

            foreach ($row as $val) {
              $url = "./assets/images/" . $val['photo'] . "')\"";
            ?>

              <li class="scrollbar-item">
                <div class="hero-card has-bg-image" style="background-image:url('<?= $url ?>">

                  <div class="card-content">

                    <h1 class="h1 hero-title">
                      <?= $titreH1 ?> <br>
                      <?= $titreH2 ?>
                    </h1>

                    <p class="hero-text">
                    <?= $descriptionH ?>
                    </p>

                    <p class="price"><?= $partir ?>  <?= $min .' '. $mad ?></p>

                    <a href="#produits" class="btn btn-primary"><?= $achter ?></a>

                  </div>

                </div>
              </li>
            <?php } ?>




          </ul>

        </div>
      </section>





      <!-- 
        - #COLLECTION
      -->

      <section class="section collection" id="collection" aria-label="collection" data-section>
        <div class="container">

          <ul class="collection-list">
            <?php
            $req = $db->prepare("SELECT * FROM collection ORDER BY RAND() limit 3");
            $req->execute();
            $row = $req->fetchAll();

            $sql = $db->prepare("SELECT min(p.prix) as cp from pr_collection pc inner join product p on pc.idp=p.idp 
            where pc.idc=?");

            foreach ($row as $val) {
              $sql->execute([$val['idc']]);
              $url = "./assets/images/" . $val['photo'] . "')\"";
            ?>
              <li>
                <div class="collection-card has-before hover:shine">

                  <h2 class="h2 card-title"><?= $val['nomc'] ?></h2>

                  <p class="card-text"><?= $partir ?> <?= $sql->fetch()['cp'].' '.$mad ?></p>

                  <a href="collection.php?idc=<?= $val['idc'] ?>" class="btn-link">
                    <span class="span"><?= $achter ?></span>

                    <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                  </a>

                  <div class="has-bg-image" style="background-image: url('<?= $url ?>')"></div>

                </div>
              </li>
            <?php } ?>

          </ul>

        </div>
      </section>





      <!-- 
        - #produits
      -->

      <section class="section shop" id="produits" aria-label="shop" data-section>
        <div class="container">

          <div class="title-wrapper">
            <h2 class="h2 section-title"><?= $produit ?></h2>

            <a href="index.php#produits" class="btn-link">
              <span class="span"><?= $Tousproduit ?></span>

              <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
            </a>
          </div>

          <ul class="has-scrollbar">
            <?php
            if (!isset($_GET['search'])) {
              $req = $db->prepare("SELECT * FROM product ORDER BY RAND()");
              $req->execute();
              $row = $req->fetchAll();
            } else {
              $req = $db->prepare("SELECT * FROM product where nom =?");
              $req->execute([$_GET['nom']]);
              $row = $req->fetchAll();
              $cp = $req->rowCount();
            }

            foreach ($row as $val) {
              $url = "./assets/images/" . $val['photo'];
            ?>
              <li class="scrollbar-item">
                <div class="shop-card">

                  <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                    <img src=<?= $url ?> width="540" height="720" loading="lazy" alt="Facial cleanser" class="img-cover">
                    <?php if ($val['remise'] != 0) { ?>
                      <span class="badge" aria-label="20% off">-<?= $val['remise'] ?>%</span>
                    <?php } ?>
                    <div class="card-actions">

                      <a href="pannier.php?id=<?= $val['idp'] ?>" class="action-btn" aria-label="add to cart">
                        <ion-icon name="bag-handle-outline" aria-hidden="true"></ion-icon>
                      </a>



                    </div>
                  </div>

                  <div class="card-content">

                    <div class="price">
                      <?php if ($val['remise'] != 0) { ?>
                        <del class="del">150.00 DH</del>
                      <?php } ?>
                      <span class="span"><?= $val['prix'] ?> DH</span>
                    </div>

                    <h3>
                      <a href="detai.php?id=<?= $val['idp'] ?>" class="card-title"><?= $val['nom'] ?></a>
                    </h3>

                  </div>

                </div>
              </li>
            <?php }
            if (isset($cp) && $cp < 1) {
              echo "<div class='alert alert-warning w-100' role='alert'>Il n'y a pas de produit avec ce nom <a href='index.php#produits'>Afficher Tous les produits</a></div>";
            }
            ?>
          </ul>

        </div>
      </section>

      <section class="section shop" id="shop" aria-label="shop" data-section>
        <div class="container">

          <div class="title-wrapper">
            <h2 class="h2 section-title"><?= $moins50 ?></h2>
          </div>

          <ul class="has-scrollbar">
            <?php
            $req = $db->prepare("SELECT * from product where prix<50 ORDER BY RAND() limit 6 ");
            $req->execute();
            $row = $req->fetchAll();
            foreach ($row as $val) {
              $url = "./assets/images/" . $val['photo'];
            ?>
              <li class="scrollbar-item">
                <div class="shop-card">

                  <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                    <img src=<?= $url ?> width="540" height="720" loading="lazy" alt="Facial cleanser" class="img-cover">

                    <?php if ($val['remise'] != 0) { ?>
                      <span class="badge" aria-label="20% off">-<?= $val['remise'] ?>%</span>
                    <?php } ?>

                    <div class="card-actions">

                      <a href="pannier.php?id=<?= $val['idp'] ?>" class="action-btn" aria-label="add to cart">
                        <ion-icon name="bag-handle-outline" aria-hidden="true"></ion-icon>
                      </a>

                    </div>
                  </div>

                  <div class="card-content">

                    <div class="price">
                      <?php if ($val['remise'] != 0) { ?>
                        <del class="del">150.00 DH</del>
                      <?php } ?>

                      <span class="span"><?= $val['prix'] ?> DH</span>
                    </div>

                    <h3>
                      <a href="detai.php?id=<?= $val['idp'] ?>" class="card-title"><?= $val['nom'] ?></a>
                    </h3>

                  </div>

                </div>
              </li>
            <?php } ?>

          </ul>

        </div>
      </section>

      <!-- 
        - #FEATURE
      -->

      <section class="section feature" aria-label="feature" data-section>
        <div class="container">

          <h2 class="h2-large section-title"><?= $qestion ?></h2>

          <ul class="flex-list">

            <li class="flex-item">
              <div class="feature-card">

                <img src="./assets/images/feature-1.jpg" width="204" height="236" loading="lazy" alt="Guaranteed PURE" class="card-icon">

                <h3 class="h3 card-title"><?= $titreQ1 ?></h3>

                <p class="card-text">
                <?= $desc1 ?>
                </p>

              </div>
            </li>

            <li class="flex-item">
              <div class="feature-card">

                <img src="./assets/images/feature-2.jpg" width="204" height="236" loading="lazy" alt="Completely Cruelty-Free" class="card-icon">

                <h3 class="h3 card-title"><?= $titreQ2 ?></h3>

                <p class="card-text">
                <?= $desc2 ?>
                </p>

              </div>
            </li>

            <li class="flex-item">
              <div class="feature-card">

                <img src="./assets/images/feature-3.jpg" width="204" height="236" loading="lazy" alt="Ingredient Sourcing" class="card-icon">

                <h3 class="h3 card-title"><?= $titreQ3 ?></h3>

                <p class="card-text">
                <?= $desc3 ?>
                </p>

              </div>
            </li>

          </ul>

        </div>
      </section>





      <!-- 
        - #OFFER
      -->

      <section class="section offer" id="offer" aria-label="offer" data-section>
        <div class="container">
          <?php
          $req = $db->prepare("SELECT p.idp, id,datefin,o.remise,photo,prix,nom,description, datefin-CURDATE() AS d from offre o inner join product p on p.idp=o.idp where datefin-CURDATE()>0 limit 1");
          $req->execute();
          $row = $req->fetch();
          $url = "./assets/images/" . $row['photo'];
          ?>
          <figure class="offer-banner">
            <img src="./assets/images/photo_5924762709314878665_x.jfif" width="305" height="408" loading="lazy" alt="offer products" class="w-100">

            <img src=<?= $url ?> width="450" height="625" loading="lazy" alt="offer products" class="w-100">
          </figure>

          <div class="offer-content">

            <p class="offer-subtitle">
              <span class="span"><?= $Toffre ?></span>

              <span class="badge" aria-label="20% off">-<?= $row['remise'] ?? 'default' ?> %</span>
            </p>

            <h2 class="h2-large section-title"><?= $row['nom'] ?></h2>

            <p class="section-text">
              <?= $row['description'] ?>
            </p>

            <div class="countdown">

              <span class="time" aria-label="days"> <?= $Valable ?><?= $row['d'].' '.$jour ?></span>

            </div>
            <?php $prix = $row['prix'] - $row['prix'] * $row['remise'] / 100 ?>
            <a href="confirm.php?idp=<?= $row['idp'] ?>&prix=<?= $prix ?> " class="btn btn-primary onClick">Obtenez seulement <?= $prix ?> DH</a>

          </div>

        </div>
      </section>





      <!-- 
        - #BLOG
      -->

      <section class="section blog" id="blog" aria-label="blog" data-section>
        <div class="container">

          <h2 class="h2-large section-title"><?= $titreBlog ?></h2>

          <ul class="flex-list">
            <?php
            $req = $db->prepare("SELECT * from blog order by rand() limit 3");
            $req->execute();
            $row = $req->fetchAll();
            foreach ($row as $val) {
              $url = "./assets/images/" . $val['photo'];
            ?>

              <li class="flex-item">
                <div class="blog-card">

                  <figure class="card-banner img-holder has-before hover:shine" style="--width: 700; --height: 450;">
                    <img src=<?= $url ?> width="700" height="450" loading="lazy" alt="Find a Store" class="img-cover">
                  </figure>

                  <h3 class="h3">
                    <a href="blog.php?pdf=<?= $val['pdf'] ?>" class="card-title"><?= $val['titre'] ?></a>
                  </h3>

                </div>
              </li>
            <?php } ?>

          </ul>

        </div>
      </section>

    </article>
  </main>





  <!-- 
    - #FOOTER
  -->

  <footer class="footer" data-section>
    <div class="container">

      <div class="footer-top">

        <h1 class="nom"><?= $footer ?></h1>

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
  <script type="module" integrity="filehash" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule integrity="filehash" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>