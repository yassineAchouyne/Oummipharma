<?php
include_once "sessionAdmin.php";
include_once "incAdmin/hedear.php";
?>
<h1 align="center" class="text-success">Gestion des Collection</h1>
<?php
include_once "../inc/db.php";
$sql = $db->prepare("SELECT nomc,idp,p.idc,photo from collection c inner join pr_collection p on c.idc=p.idc;");
$sql->execute();
$tab = $sql->fetchAll();
if (empty($_GET['mdf'])) {
?>
    <table class='table table-striped mt-2'>
        <tr class="bg-cl text-white row-12">
            <td class="col-2">Photo de Collection</td>
            <td class="col-2">Nom de Collection</td>
            <td class="col-3">Produit</td>
            <td class="col-2">action</td>
        </tr>
        <?php foreach ($tab as $val) { ?>

            <tr>
                <td><img src="../assets/images/<?= $val['photo'] ?>" alt="" class="img-thumbnail imgg"> </td>
                <td><?= $val['nomc'] ?></td>
                <td><?= $val['idp'] ?></td>
                <td>
                    <a href="?idp=<?= $val['idp'] ?>&idc=<?= $val['idc'] ?>" onclick="return confirm('Voulez-vous supprimer le Couffre') "><i class="fa-solid fa-xmark"></i></a>
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
if (isset($_GET['idp'])&&isset($_GET['idc'])) {
    $spp = $db->prepare("DELETE  FROM pr_collection WHERE idp=? and idc=?");
    $spp->execute([$_GET['idp'],$_GET['idc']]);
    unset($_GET['idc'],$_GET['idp']);
    echo '<script>location.href="Gestion_des_collection.php"</script>';
}

?>