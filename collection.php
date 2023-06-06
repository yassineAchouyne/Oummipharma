<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/collection.css">
  <link rel="shortcut icon" href="assets/images/logol.png" type="image/svg+xml">

  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9" integrity="filehash"></script>

    <title>Collection</title>
</head>

<body>
    <div class="heading">
        <h1>

        <?php 
        
        include_once('inc/lang.php');
        include_once('inc/db.php');
        if (!empty($_GET['idc'])) {


            $req = $db->prepare("SELECT nomc from collection  where idc=?");
            $req->execute([$_GET['idc']]);
            $prd = $req->fetch();
            echo $prd['nomc'];
        }
        
        ?>
        </h1>
    </div>
    <div class="container">
        <?php
        if (!empty($_GET['idc'])) {


            $req = $db->prepare("SELECT *  from pr_collection pc inner join product p on pc.idp=p.idp where pc.idc=?");
            $req->execute([$_GET['idc']]);
            $prd = $req->fetchAll();
            foreach ($prd as $val) {
                $url = "./assets/images/" . $val['photo'];

        ?>
                <div class="box">
                    <img src="<?= $url ?>">
                    <h2><?= $val['nom'] ?></h2>
                    <span><?= $val['prix'] ?> DH</span><br>
                </div>
        <?php }
        } ?>

</div>
<div class="options">
    <a onclick="history.back()"><?= $revenir ?></a>
    <a href="confirm.php?idc=<?= $_GET['idc'] ?> " class="onClick"><?= $achter ?></a>
</div>
<script src="assets/js/script.js"></script>
</body>

</html>