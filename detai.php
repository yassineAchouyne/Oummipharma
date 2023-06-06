<?php 
session_start();
include_once('inc/lang.php');
include_once "inc/db.php";
if(isset($_GET['id'])){
    $res=$db->prepare("SELECT * from product where idp=?");
    $res->execute([$_GET['id']]);
    $prd=$res->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/detai.css">
    <title>détails du produit</title>
    <link rel="shortcut icon" href="assets/images/logol.png" type="image/svg+xml">
</head>
<body>
    <div class="container">
        <div class="box">
            <div class="images">
                <div class="img-holder active">
                    <img src="assets/images/<?= $prd['photo'] ?>">
                </div>
                
            </div>
            <div class="basic-info">
                <h1><?= $prd['nom'] ?></h1>
                
                <span><?= $prd['prix'] ?> DH</span>
                <div class="options">
                    <a onclick="history.back()"><?= $revenir ?></a>
                    <a href="pannier.php?id=<?= $prd['idp']?>"><?= $ajoutercard ?></a>
                </div>
            </div>
            <div class="description">
                <p><?= $prd['description'] ?></p>
                
            </div>
        </div>
    </div>
</body>
</html>