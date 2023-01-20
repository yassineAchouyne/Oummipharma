<?php
include "sessionAdmin.php";
include "incAdmin/hedear.php";
?>
<h1 align="center" class="text-success">Gestion des Offre</h1>
<?php
include "../inc/db.php";
$sql = $db->prepare("SELECT * from offre");
$sql->execute();
$tab = $sql->fetchAll();
if (empty($_GET['mdf'])) {
?>
    <table class='table table-striped mt-2'>
        <tr class="bg-cl text-white row-12">
            <td class="col-2">Date Fin</td>
            <td class="col-2">Remise</td>
            <td class="col-3">Produit</td>
            <td class="col-2">action</td>
        </tr>
        <?php foreach ($tab as $val) { ?>

            <tr>
                <td><?= $val['datefin'] ?></td>
                <td><?= $val['remise'] ?> %</td>
                <td><?= $val['idp'] ?></td>
                <td>
                    <a href="?sepp=<?= $val['id'] ?>" onclick="return confirm('Voulez-vous supprimer le Couffre') "><i class="fa-solid fa-xmark"></i></a>
                    <a href="?mdf=<?= $val['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php } else {

    $sql = $db->prepare("SELECT * from offre where id=?");
    $sql->execute([$_GET['mdf']]);
    $tab = $sql->fetch();
    

?>

    <div class="adminbody">
        <form action="" method="post" enctype="multipart/form-data">
            <div>
                <label for="">Date fin :</label>
                <input type="date" name="date" value="<?= $tab['datefin'] ?>" placeholder="Libellé du produit" class="form-control">
            </div>
            <div>
                <label for="">Remise :</label>
                <input type="number" name="remise" value="<?=  $tab['remise'] ?>" class="form-control">
            </div>
            <div>
                <label for="">Produit :</label>
                <select name="idp">
                <?php 
                    $req=$db->prepare("SELECT idp,nom from product");
                    $req->execute();
                    $prd=$req->fetchAll();
                    foreach($prd as $val){
                ?>
                <option value=<?=$val['idp']?>><?=$val['nom']?></option>
                <?php } ?>
            </select>
            </div>
            <div>
                <input type="submit" value="Modifier de ordinateur" name="Modifier">

            </div>
            <div>
                <a href="Gestion_des_couffre.php" class="btn btn-outline-danger">Gestion Des Couffre</a>
            </div>
        </form>
    </div>


<?php
    if (isset($msg)) echo $msg;
    if (isset($_POST['Modifier'])) {
        $remise = $_POST['remise'];
        $idp = $_POST['idp'];
        $date = $_POST['date'];
        $m = $_GET['mdf'];

        $mdf = $db->prepare("UPDATE offre
    SET remise=:rm,datefin=:df,idp=:idp 
    WHERE id=:id");
        $mdf->execute([":rm" => $remise, ":df" => $date, ":idp" => $idp,":id" => $m]);
    }
}
if (isset($_GET['sepp'])) {
    $spp = $db->prepare("DELETE  FROM offre WHERE id=?");
    $spp->execute([$_GET['sepp']]);
    unset($_GET['sepp']);
    echo '<script>location.href="Gestion_des_couffre.php"</script>';
}

?>