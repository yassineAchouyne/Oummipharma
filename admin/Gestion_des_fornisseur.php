<?php
include "sessionAdmin.php";
include "incAdmin/hedear.php";
?>
<h1 align="center" class="text-success">Gestion des Fornisseur</h1>
<?php
include "../inc/db.php";
$sql = $db->prepare("SELECT * from fhome");
$sql->execute();
$tab = $sql->fetchAll();
if (empty($_GET['mdf'])) {
?>
    <table class='table table-striped mt-2'>
        <tr class="bg-cl text-white row-12">
            <td class="col-2">Image</td>
            <td class="col-2">Action</td>
        </tr>
        <?php foreach ($tab as $val) { ?>

            <tr>
                <td><img src="../assets/images/<?= $val['photo'] ?>" alt="" class="img-thumbnail imgg"> </td>
                <td>
                    <a href="?sepp=<?= $val['idf'] ?>" onclick="return confirm('Voulez-vous supprimer le Couffre') "><i class="fa-solid fa-xmark"></i></a>
                    <a href="?mdf=<?= $val['idf'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php } else {

    $sql = $db->prepare("SELECT * from fhome where idf=?");
    $sql->execute([$_GET['mdf']]);
    $tab = $sql->fetch();

?>

    <div class="adminbody">
        <form action="" method="post" enctype="multipart/form-data">
            <div>
                <label for="">Photo du home :</label>
                <input type="file" name="c_image" value="<?= $tab['photo'] ?>" class="form-control">
            </div>
            <div>
                <input type="submit" value="Modifier un photo" name="Modifier">
            </div>
            <div>
                <a href="Gestion_des_fornisseur.php" class="btn btn-outline-danger">Gestion Des Photo</a>
            </div>
        </form>
    </div>


<?php

    if (isset($_POST['Modifier'])) {
        $tmp_image = $_FILES['c_image'];

        copy($tmp_image['tmp_name'], "../assets/images/". $tmp_image['name']);

        $mdf = $db->prepare("UPDATE fhome
    SET photo=:img
    WHERE idf=:id");
        $mdf->execute([":img" => $tmp_image['name'],":id" => $m]);
    }
}
if (isset($_GET['sepp'])) {
    $spp = $db->prepare("DELETE  FROM fhome WHERE idf=?");
    $spp->execute([$_GET['sepp']]);
    unset($_GET['sepp']);
    echo '<script>location.href="Gestion_des_fornisseur.php"</script>';
}

?>