<?php
include_once "inc/session.php";
include_once "inc/db.php";

// ajouter les produits si le variable id existe
if (isset($_GET['id'])) {
  $req = $db->prepare("INSERT INTO produit_panier values(?,?,?,?)");
  $req->execute([null, $_GET['id'], $_SESSION['id_clien'], "instance"]);
  echo "<script>history.back()</script>";
}

//supprimer les produits si la variable del existe
if (isset($_GET['del'])) {
  $req = $db->prepare("DELETE from produit_panier where id=?");
  $req->execute([$_GET['del']]);
  header("Location : pannier.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="assets/images/logol.png" type="image/svg+xml">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="./assets/css/style.css">

  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

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
          <input type="search" name="search" placeholder="Search product" class="search-field">

          <button class="search-submit" aria-label="search">
            <ion-icon name="search-outline" aria-hidden="true"></ion-icon>
          </button>
        </div>

        <a href="#" class="logo">
          <img src="./assets/images/logol.png" width="85" height="22" alt="Glowing">
        </a>

        <div class="header-actions">

          <a href="login.php" class="header-action-btn" aria-label="user">
            <ion-icon name="person-outline" aria-hidden="true" aria-hidden="true"></ion-icon>
          </a>

          <a href="pannier.php" class="header-action-btn" aria-label="cart item">

            <ion-icon name="bag-handle-outline" aria-hidden="true" aria-hidden="true"></ion-icon>

            <span class="btn-badge">
              <?php
              $req = $db->prepare("SELECT count(*) as cp from produit_panier where idc=? and statut='instance'");
              $req->execute([$_SESSION['id_clien']]);
              echo $req->fetch()['cp'];
              ?>
            </span>
          </a>

        </div>

        <nav class="navbar">
          <ul class="navbar-list">

            <li>
              <a href="index.php" class="navbar-link has-after">Home</a>
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
          <img src="./assets/images/logo.png" width="179" height="26" alt="Glowing">
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

      </ul>

    </div>

    <div class="overlay" data-nav-toggler data-overlay></div>
  </div>

  <div class="panier">
    <section>
      <table aria-describedby="mydesc">
        <th>
          <th>Image</th>
          <th>Nom</th>
          <th>Prix</th>
          <th>Action</th>
        </th>
        <?php
        $total = 0;
        $req = $db->prepare("SELECT * from produit_panier where idc=? and statut='instance'");
        $req->execute([$_SESSION['id_clien']]);
        $row = $req->fetchAll();
        $tab=[];
        $i=0;
        foreach ($row as $val) {
          $sql = $db->prepare("SELECT * from product where idp=?");
          $sql->execute([$val['idp']]);
          $prd = $sql->fetch();
          $total = $total + $prd['prix'];
          $tab[$i]=$val['idp'];
          $i++;
        ?>
          <tr>
            <td><img src="assets/images/<?= $prd['photo'] ?>"></td>
            <td><?= $prd['nom'] ?></td>
            <td><?= $prd['prix'] ?> DH</td>
            <td class="delet"><a href="pannier.php?del=<?= $val['id'] ?>"><img src="/assets/images/delete.png"></a></td>
      </tr>

        <?php }
        ?>

        <tr class="total">
          <th>Total : <?= $total ?> DH</th>
          
          <th>
            <?php 
           if($total!=0){
            $table = json_encode($tab);
            $table=  urlencode($table) ;
            ?>
              <a class="btn btn-primary onClick" href="confirm.php?tab=<?=$table?>">confirmer demande</a>
           <?php }
          ?>
          </th>
        </tr>
      </table>
    </section>
  </div>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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