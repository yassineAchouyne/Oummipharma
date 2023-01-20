<?php
include "sessionAdmin.php";
include "incAdmin/hedear.php";
?>
<?php
include "../inc/db.php";
if (isset($_POST["ajouter"])) {
    $nom = $_POST['c_name'];
    $prix = $_POST['c_prix'];
    $description = $_POST['c_description'];
    $tmp_image = $_FILES['c_image'];


    try {
        if (!empty($nom) && !empty($description) && !empty($tmp_image)  && !empty($prix)) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                copy($tmp_image['tmp_name'], "../assets/images/" . $tmp_image['name']);
            }
            $sql = $db->prepare("INSERT INTO `product`( `nom`, `photo`, `prix`, `description`) values (:nom,:img,:prix,:decs )");
            $sql->execute([":nom" => $nom, ":img" => $tmp_image['name'],  ":prix" => $prix, ":decs" => $description]);
            echo '<div class="alert alert-success" role="alert"> Ajouté avec succès!</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Erreur Produit non ajouté!</div>';
        }
    } catch (PDOException $e) {
        die("erreur " . $e->getMessage());
    }
    unset($nom, $marque, $type, $prix, $description, $tmp_image);
}


?>


<div class="adminbody">
    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <label for="">Libellé du produit :</label>
            <input type="text" name="c_name" id="" placeholder="Libellé du produit" class="form-control">
        </div>
        <div>
            <label for="">Photo du produit :</label>
            <input type="file" name="c_image" id="" class="form-control">
        </div>
        <div>
            <label for="">Prix du produit :</label>
            <input type="number" name="c_prix" id="" class="form-control">
        </div>
        <div>
            <label for="">Description du produit :</label>
            <textarea name="c_description" id="" cols="5" rows="10" class="form-control"></textarea>
        </div>
        <div>
            <input type="submit" value="ajouter un produit" name="ajouter">
        </div>
    </form>


</div>
</body>

</html>