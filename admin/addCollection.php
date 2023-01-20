<?php
include "sessionAdmin.php";
include "incAdmin/hedear.php";
?>
<?php
include "../inc/db.php";
if (isset($_POST["ajouter"])) {
    $nom = $_POST['nom'];
    $tmp_image = $_FILES['c_image'];
    try {
        if (!empty($nom)&&!empty($tmp_image)) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                
                copy($tmp_image['tmp_name'], "../assets/images/" . $tmp_image['name']);
            }
            $sql = $db->prepare("INSERT INTO collection  values (?,?,?)");
            $sql->execute([null,$nom,$tmp_image['name']]);
            echo '<div class="alert alert-success" role="alert"> Ajouté avec succès!</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Erreur collection non ajouté!</div>';
        }
    } catch (PDOException $e) {
        die("erreur " . $e->getMessage());
    }
    unset($nom);
}
if (isset($_POST["ajouterPR"])) {
    $idc = $_POST['idc'];
    $idp = $_POST['idp'];


    try {
        if ( !empty($idc)&&!empty($idp)) {
            $sql = $db->prepare("SELECT count(*) as cp from pr_collection where idc=? and idp=?");
            $sql->execute([$idc,$idp]);
            if($sql->fetch()['cp']<1){
                $sql = $db->prepare("INSERT INTO pr_collection values (?,?,?)");
                $sql->execute([null,$idc,$idp]);
                echo '<div class="alert alert-success" role="alert"> Ajouté avec succès!</div>';
            }else{
                echo '<div class="alert alert-warning" role="alert">Produit deja ajouté sur collection!</div>';
            }
            
        } else {
            echo '<div class="alert alert-danger" role="alert">Produit non ajouté sur collection!</div>';
        }
    } catch (PDOException $e) {
        die("erreur " . $e->getMessage());
    }
    unset($idc,$idp);
}

?>


<div class="adminbody form2">
    <form action="" method="post" enctype="multipart/form-data">
        <h4 class="titreForm">Ajouter un nouvelle Collection</h4>
        <div>
            <label for="">Nom du Collection :</label>
            <input type="text" name="nom" id="" placeholder="nom de collection " class="form-control">
        </div>
        <div>
            <label for="">Photo du Collection :</label>
            <input type="file" name="c_image" id="" class="form-control">
        </div>
        
        <div>
            <input type="submit" value="ajouter un Collection" name="ajouter">
        </div>
    </form>

    <form action="" method="post" enctype="multipart/form-data">
    <h4 class="titreForm">Ajouter un produit sur Collection</h4>
        <div>
        <label for="">Le Collection :</label>
        <select name="idc" id="">
                <?php 
                    $req=$db->prepare("SELECT idc,nomc from Collection");
                    $req->execute();
                    $prd=$req->fetchAll();
                    foreach($prd as $val){
                ?>
                <option value=<?=$val['idc']?>><?=$val['nomc']?></option>
                <?php } ?>
            </select>
        </div>
        <div>
        <label for="">Le Produit:</label>
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
            <input  type="submit" value="ajouter produit sur Collection" name="ajouterPR">
        </div>
    </form>
</div>
</body>

</html>