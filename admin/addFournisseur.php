<?php
include_once "sessionAdmin.php";
include_once "incAdmin/hedear.php";
?>
<?php
include_once "../inc/db.php";
if (isset($_POST["ajouter"])) {
    $tmp_image = $_FILES['c_image'];

    try {

        if (!empty($tmp_image)) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                copy($tmp_image['tmp_name'], "../assets/images/" . $tmp_image['name']);
            }
            $sql = $db->prepare("INSERT INTO fhome(photo)  values (:img)");
            $sql->execute([":img" => $tmp_image['name']]);
            echo '<div class="alert alert-success" role="alert"> Ajouté avec succès!</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Erreur Photo non ajouté!</div>';
        }
    } catch (PDOException $e) {
        die("erreur " . $e->getMessage());
    }
    unset($tmp_image);
}


?>


<div class="adminbody">
    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <label for="">Photo du page home :</label>
            <input type="file" name="c_image" id="" class="form-control">
        </div>
        <div>
            <input type="submit" value="ajouter un photo" name="ajouter">
        </div>
    </form>


</div>
</body>

</html>