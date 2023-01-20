<?php

include_once 'inc/session.php';
include_once 'inc/db.php';
if (!empty($_GET['tab'])) {
  $table=$_GET['tab'];

urldecode($table);

$tab[]=json_decode($table);

  foreach ($tab as $val){
    foreach($val as $t){
      
        $req = $db->prepare("UPDATE  produit_panier  set statut='delivered' where idp=? and idc=? ");
        $req->execute([$t,$_SESSION['id_clien']]);
      

    }
  }

}

if(!empty($_GET['idc'])){
  $req = $db->prepare("INSERT into cmd_collection values(null,?,?,'instance')");
  $req->execute([$_GET['idc'],$_SESSION['id_clien']]);
}


if(!empty($_GET['idp'])&&!empty($_GET['prix'])){
  $req = $db->prepare("INSERT into cmd_offre values(null,?,?,?,'instance')");
  $req->execute([$_GET['idp'],$_GET['prix'],$_SESSION['id_clien']]);
}

?>

<!DOCTYPE html>
<html>

<head>
  <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet' rel="stylesheet" />
  <link href="assets/css/confirm.css" rel="stylesheet" />
  <title>Success</title>
</head>

<body>
  <div class="popu" id="succes">
    <div class="popup-content">
      <div class="imgbox">
        <img src="/assets/images/checked.png" alt="" class="img">
      </div>
      <div class="title">
        <h3>Succès!</h3>
      </div>
      <p class="para">Votre demande a été soumise avec succès</p>
      <form action="">
        <a href="index.php" class="button" id="s_button">D'ACCORD</a>
      </form>
    </div>
  </div>
</body>

</html>