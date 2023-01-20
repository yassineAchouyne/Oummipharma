<?php
include "sessionAdmin.php";
include "incAdmin/hedear.php";
?>
<?php
include "../inc/db.php";
if (isset($_POST["ajouter"])) {
    $remise = $_POST['remise'];
    $idp = $_POST['idp'];
    $date = $_POST['date'];


    try {
        if (!empty($remise) && !empty($idp)) {
            $sql = $db->prepare("INSERT INTO offre(datefin ,remise ,idp)  values (:dfin,:rem,:id )");
            $sql->execute([":dfin" => $date, ":rem" => $remise, ":id" => $idp]);
            echo '<div class="alert alert-success" role="alert"> Ajouté avec succès!</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Erreur Offre non ajouté!</div>';
        }
    } catch (PDOException $e) {
        die("erreur " . $e->getMessage());
    }
    unset($remise, $idp, $date);
}


?>


<div class="adminbody">
    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <label for="">Date fin du offre :</label>
            <input type="date" name="date" id="" placeholder="date fin" class="form-control">
        </div>
        <div>
            <label for="">Remise du offre :</label>
            <input type="number" name="remise" id="" placeholder="remise de offre" class="form-control">
        </div>
        <div>
            <label for="">Select le produit :</label>
            <select name="idp" id="">
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
            <input type="submit" value="ajouter un offre" name="ajouter">
        </div>
    </form>


</div>
</body>

</html>