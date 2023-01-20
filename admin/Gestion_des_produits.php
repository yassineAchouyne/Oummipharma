<?php
include_once "sessionAdmin.php";
include_once "incAdmin/hedear.php";
?>
<h1 align="center" class="text-success">Gestion des Produit</h1>
<?php
include_once "../inc/db.php";
$sql = $db->prepare("SELECT * from product");
$sql->execute();
$tab = $sql->fetchAll();
if (empty($_GET['mdf'])) {
?>
    <table class='table table-striped mt-2'>
        <tr class="bg-cl text-white row-12">
            <td class="col-2">Image</td>
            <td class="col-2">Nom</td>
            <td class="col">Prix</td>
            <td class="col-3">Description</td>
            <td class="col-2">action</td>
        </tr>
        <?php foreach ($tab as $val) { ?>

            <tr>
                <td><img src="../assets/images/<?= $val['photo']?>" alt="" class="img-thumbnail imgg"> </td>
                <td><?= $val['nom'] ?></td>
                <td><?= $val['prix'] ?>DH</td>
                <td><?= $val['description'] ?></td>
                <td>
                    <a href="?sepp=<?= $val['idp'] ?>" onclick="return confirm('Voulez-vous supprimer le produit') "><i class="fa-solid fa-xmark"></i></a>
                    <a href="?mdf=<?= $val['idp'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php } else {

    $sql = $db->prepare("SELECT * from product where idp=?");
    $sql->execute([$_GET['mdf']]);
    $tab = $sql->fetch();

?>

    <div class="adminbody">
        <form action="" method="post" enctype="multipart/form-data">
            <div>
                <label for="">Libellé du ordinateur :</label>
                <input type="text" name="c_name" value="<?= $tab['nom'] ?>" placeholder="Libellé du produit" class="form-control">
            </div>
            <div>
                <label for="">Photo du ordinateur :</label>
                <input type="file" name="c_image" value="image<?= $tab['photo'] ?>" class="form-control">
            </div>
            <div>
                <label for="">Prix du ordinateur :</label>
                <input type="number" name="c_prix" value="<?= $tab['prix'] ?>" class="form-control">
            </div>
            <div>
                <label for="">Description du ordinateur :</label>
                <textarea name="c_description" cols="5" rows="10" class="form-control"><?= $tab['description'] ?></textarea>
            </div>
            <div>
                <input type="submit" value="Modifier de ordinateur" name="Modifier">

            </div>
            <div>
                <a href="Gestion_des_produits.php" class="btn btn-outline-danger">Gestion des produits</a>
            </div>
        </form>
    </div>


<?php
    if (isset($msg)) echo $msg;
    if (isset($_POST['Modifier'])) {
        $nom = $_POST['c_name'];
        $prix = $_POST['c_prix'];
        $description = $_POST['c_description'];
        $tmp_image = $_FILES['c_image'];
        $m = $_GET['mdf'];

        copy($tmp_image['tmp_name'], "../assets/images/" . $tmp_image['name']);

        $mdf = $db->prepare("UPDATE product
    SET nom=:nom,photo=:img,prix=:prix,description=:decs 
    WHERE idp=:id");
        $mdf->execute([":nom" => $nom, ":img" => $tmp_image['name'],":prix" => $prix, ":decs" => $description, ":id" => $m]);
    }
}
if (isset($_GET['sepp'])) {
    $spp = $db->prepare("DELETE  FROM product WHERE idp=?");
    $spp->execute([$_GET['sepp']]);
    unset($_GET['sepp']);
    echo '<script>location.href="Gestion_des_produits.php"</script>';
}

?>