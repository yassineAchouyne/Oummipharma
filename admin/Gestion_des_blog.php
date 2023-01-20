<?php
include "sessionAdmin.php";
include "incAdmin/hedear.php";
?>
<h1 align="center" class="text-success">Gestion des Blog</h1>
<?php
include "../inc/db.php";
$sql = $db->prepare("SELECT * from blog");
$sql->execute();
$tab = $sql->fetchAll();
if (empty($_GET['mdf'])) {
?>
    <table class='table table-striped mt-2'>
        <tr class="bg-cl text-white row-12">
            <td class="col-2">Image</td>
            <td class="col-2">Nom</td>
            <td class="col-2">action</td>
        </tr>
        <?php foreach ($tab as $val) { ?>

            <tr>
                <td><img src="../assets/images/<?= $val['photo'] ?>" alt="" class="img-thumbnail imgg"> </td>
                <td><?= $val['titre'] ?></td>
                <td>
                    <a href="?sepp=<?= $val['idb'] ?>" onclick="return confirm('Voulez-vous supprimer le Couffre') "><i class="fa-solid fa-xmark"></i></a>
                    <a href="?mdf=<?= $val['idb'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php } else {

    $sql = $db->prepare("SELECT * from blog where idb=?");
    $sql->execute([$_GET['mdf']]);
    $tab = $sql->fetch();

?>

    <div class="adminbody">
        <form action="" method="post" enctype="multipart/form-data">
        <div>
            <label for="">Libellé du Blog :</label>
            <input type="text" name="c_name" id="" value="<?= $tab['titre'] ?>" placeholder="Libellé du Blog" class="form-control">
        </div>
        <div>
            <label for="">Photo du Blog :</label>
            <input type="file" name="c_image" value="<?= $tab['photo'] ?>" id="" class="form-control">
        </div>
        <div>
            <label for="">Description du Blog :</label>
            <textarea name="c_description" id="" cols="40" rows="10" value="" class="form-control"><?= $tab['description'] ?></textarea>
        </div>
            <div>
                <input type="submit" value="Modifier un blog" name="Modifier">
            </div>
            <div>
                <a href="Gestion_des_blog.php" class="btn btn-outline-danger">Gestion Des Blog</a>
            </div>
        </form>
    </div>


<?php

    if (isset($_POST['Modifier'])) {
        $nom = $_POST['c_name'];
        $description = $_POST['c_description'];
        $tmp_image = $_FILES['c_image'];
        $m = $_GET['mdf'];

        copy($tmp_image['tmp_name'], "../assets/images/" . $tmp_image['name']);

        $mdf = $db->prepare("UPDATE blog
    SET titre=:nom,photo=:img,description=:decs 
    WHERE idb=:id");
        $mdf->execute([":nom" => $nom, ":img" => $tmp_image['name'], ":decs" => $description, ":id" => $m]);
    }
}
if (isset($_GET['sepp'])) {
    $spp = $db->prepare("DELETE  FROM blog WHERE idb=?");
    $spp->execute([$_GET['sepp']]);
    unset($_GET['sepp']);
    echo '<script>location.href="Gestion_des_blog.php"</script>';
}

?>