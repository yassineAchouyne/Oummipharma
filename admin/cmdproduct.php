<?php
include_once "sessionAdmin.php";
include_once "../inc/db.php";
include_once "incAdmin/hedear.php";
if (empty($_POST['recherch'])) {
    $sql = $db->prepare("SELECT pp.id ,p.photo,p.nom,p.prix,c.nom cnom,c.tel from produit_panier pp inner join clien c on pp.idc = c.id
inner join product p on p.idp=pp.idp where pp.statut='delivered'");
    $sql->execute();
    $tab = $sql->fetchAll();
} else {
    $sql = $db->prepare(
        "SELECT pp.id ,p.photo,p.nom,p.prix,c.nom cnom,c.tel from produit_panier pp inner join clien c on pp.idc = c.id
inner join product p on p.idp=pp.idp where pp.statut='delivered' and c.id=?"
    );
    $sql->execute([$_POST['nom']]);
    $tab = $sql->fetchAll();
}

?>
<h1 align="center" class="text-success">les commandes des Produits</h1>
<div class="adminbody">
    <form action="" method="post">
        <div>
            <select name="nom" id="">
                <?php
                $req = $db->prepare("SELECT DISTINCT c.nom,c.id from clien c inner join produit_panier p on c.id=p.idc where p.statut='delivered'");
                $req->execute();
                $row = $req->fetchAll();
                foreach ($row as $val) {
                ?>
                <option value="<?=$val["id"]?>"><?= $val["nom"] ?></option>
                <?php } ?>
            </select>
        </div>

        <input type="submit" value="rechercher" name="recherch">
    </form>
</div>
<?php 
if (!empty($_POST['recherch'])) {
?>
<div class="adminbody">
<a href="?delt=<?= $_POST['nom'] ?>">Supprimer Tous</a>
||
<a href="?validt=<?= $_POST['nom'] ?>">Valider Tous</a>
</div>
<?php } ?>

<table class='table table-striped mt-2'>
    <twhere and statut='instance' r class="bg-cl text-white row-12">
        <td class="col-2">Image</td>
        <td class="col-2">Nom</td>
        <td class="col">Prix</td>
        <td class="col-3">Nom client</td>
        <td class="col">Tel</td>
        <td class="col-2">action</td>
    </twhere>
    <?php foreach ($tab as $val) { ?>

        <tr>
            <td><img src="../assets/images/<?= $val['photo'] ?>" alt="" class="img-thumbnail imgg"> </td>
            <td><?= $val['nom'] ?></td>
            <td><?= $val['prix'] ?> DH</td>
            <td><?= $val['cnom'] ?></td>
            <td><?= $val['tel'] ?></td>
            <td>
                <a href="?del=<?= $val['id'] ?>" onclick="return confirm('Voulez-vous supprimer le commande') "><i class="fa-solid fa-xmark"></i></a>
                <a href="?valid=<?= $val['id'] ?>" onclick="return confirm('Voulez-vous cofirmer le commande') "><i class="fa-solid fa-check"></i></a>
            </td>
        </tr>
    <?php } ?>
</table>

<?php

if (isset($_GET['valid'])) {
    $req = $db->prepare("UPDATE  produit_panier  set statut='valide' where id=?");
    $req->execute([$_GET['valid']]);
    echo '<script>location.href="cmdproduct.php"</script>';
}
if (isset($_GET['del'])) {
    $req = $db->prepare("DELETE from produit_panier where id=?");
    $req->execute([$_GET['del']]);
    echo '<script>location.href="cmdproduct.php"</script>';
}

if (isset($_GET['validt'])) {
    $req = $db->prepare("UPDATE  produit_panier  set statut='valide' where idc=?");
    $req->execute([$_GET['validt']]);
    echo '<script>location.href="cmdproduct.php"</script>';
}
if (isset($_GET['delt'])) {
    $req = $db->prepare("DELETE from produit_panier where idc=?");
    $req->execute([$_GET['delt']]);
    echo '<script>location.href="cmdproduct.php"</script>';
}

?>