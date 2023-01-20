<?php
include "sessionAdmin.php";
include "incAdmin/hedear.php";
?>
<?php
include "../inc/db.php";
if (isset($_POST["ajouter"])) {
    $nom = $_POST['c_name'];
    $tmp_image = $_FILES['c_image'];
    $tmp_pdf = $_FILES['c_pdf'];

    try {
        if (!empty($nom) && !empty($tmp_pdf) && !empty($tmp_image)) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                copy($tmp_image['tmp_name'], "../assets/images/" . $tmp_image['name']);
                copy($tmp_pdf['tmp_name'], "../assets/pdf/" . $tmp_pdf['name']);
            }
            $sql = $db->prepare("INSERT INTO blog(titre ,photo ,pdf)  values (:nom,:img,:pdf )");
            $sql->execute([":nom" => $nom, ":img" => $tmp_image['name'], ":pdf" => $tmp_pdf['name']]);
            echo '<div class="alert alert-success" role="alert"> Ajouté avec succès!</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Erreur Blog non ajouté!</div>';
        }
    } catch (PDOException $e) {
        die("erreur " . $e->getMessage());
    }
    unset($nom, $tmp_pdf, $tmp_image);
}


?>


<div class="adminbody">
    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <label for="">Libellé du Blog :</label>
            <input type="text" name="c_name" id="" placeholder="Libellé du Blog" class="form-control">
        </div>
        <div>
            <label for="">Photo du Blog :</label>
            <input type="file" name="c_image" id="" class="form-control">
        </div>
        <div>
            <label for="">Description du produit :</label>
            <input type="file" name="c_pdf" id="" class="form-control">
        </div>
        <div>
            <input type="submit" value="ajouter un blog" name="ajouter">
        </div>
    </form>
</div>
</body>

</html>