<?php
include_once "sessionAdmin.php";
include_once "../inc/db.php";
include_once "incAdmin/hedear.php";
if (empty($_POST['recherch'])) {
    $sql = $db->prepare("SELECT cmd.id, p.photo,p.nom,cmd.prix,cl.nom nomc,cl.tel from cmd_offre cmd inner join product p on p.idp=cmd.idp
    inner join clien cl on cl.id =cmd.idc where cmd.statut='valide'");
    $sql->execute();
    $tab = $sql->fetchAll();
} else {
    $sql = $db->prepare(
        "SELECT cmd.id, p.photo,p.nom ,cmd.prix,cl.nom nomc,cl.tel from cmd_offre cmd inner join product p on p.idp=cmd.idp
        inner join clien cl on cl.id =cmd.idc where cmd.statut='valide' and cl.id=?"
    );
    $sql->execute([$_POST['nom']]);
    $tab = $sql->fetchAll();
}

?>
<h1 align="center" class="text-success">les commandes des Prêt</h1>
<div class="adminbody">
    <form action="" method="post">
        <div>
            <select name="nom" id="">
                <?php
                $req = $db->prepare("SELECT nom,id from clien");
                $req->execute();
                $row = $req->fetchAll();
                foreach ($row as $val) {
                ?>
                    <option value="<?= $val["id"] ?>"><?= $val["nom"] ?></option>
                <?php } ?>
            </select>
        </div>

        <input type="submit" value="rechercher" name="recherch">
    </form>
</div>



<table class='table table-striped mt-2'>
    <caption align="top">Offre</caption>
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
            <td><?= $val['nomc'] ?></td>
            <td><?= $val['tel'] ?></td>
            <td>
                <a href="?valido=<?= $val['id'] ?>" onclick="return confirm('Voulez-vous cofirmer le commande') "><i class="fa-solid fa-check"></i></a>
            </td>
        </tr>
    <?php } ?>
</table>

<hr>
<?php

if (empty($_POST['recherch'])) {
    $sql = $db->prepare("SELECT pp.id ,p.photo,p.nom,p.prix,c.nom cnom,c.tel from produit_panier pp inner join clien c on pp.idc = c.id
inner join product p on p.idp=pp.idp where pp.statut='valide'");
    $sql->execute();
    $tab = $sql->fetchAll();
} else {
    $sql = $db->prepare(
        "SELECT pp.id ,p.photo,p.nom,p.prix,c.nom cnom,c.tel from produit_panier pp inner join clien c on pp.idc = c.id
inner join product p on p.idp=pp.idp where pp.statut='valide' and c.id=?"
    );
    $sql->execute([$_POST['nom']]);
    $tab = $sql->fetchAll();
}

?>

<table class='table table-striped mt-2'>
    <caption align="top">Produit</caption>
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
                <a href="?validp=<?= $val['id'] ?>" onclick="return confirm('Voulez-vous cofirmer le commande') "><i class="fa-solid fa-check"></i></a>
            </td>
        </tr>
    <?php } ?>
</table>

<?php

if (empty($_POST['recherch'])) {
    $sql = $db->prepare("SELECT cmd.id, c.idc ,c.photo,c.nomc,cl.nom,cl.tel from cmd_collection cmd inner join collection  c on c.idc=cmd.idc 
    inner join clien cl on cl.id =cmd.idcl where cmd.statut='valide'");
    $sql->execute();
    $tab = $sql->fetchAll();
} else {
    $sql = $db->prepare(
        "SELECT cmd.id, c.idc ,c.photo,c.nomc,cl.nom,cl.tel from cmd_collection cmd inner join collection  c on c.idc=cmd.idc 
        inner join clien cl on cl.id =cmd.idcl where cmd.statut='valide' and cl.id=?"
    );
    $sql->execute([$_POST['nom']]);
    $tab = $sql->fetchAll();
}

?>

<table class='table table-striped mt-2'>
    <caption>Collection</caption>
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
            <td><?= $val['nomc'] ?></td>
            <td><?php
            $req = $db->prepare("SELECT sum(p.prix) sum from pr_collection pr inner join product p on p.idp=pr.idp where pr.idc=?");
            $req->execute([$val['idc']]);
            echo $req->fetch()['sum'] ;
            ?> DH</td>
            <td><?= $val['nom'] ?></td>
            <td><?= $val['tel'] ?></td>
            <td>
                 <a href="?validc=<?= $val['id'] ?>" onclick="return confirm('Voulez-vous cofirmer le commande') "><i class="fa-solid fa-check"></i></a>
            </td>
        </tr>
    <?php } ?>
</table>


<?php


if (isset($_GET['valido'])) {
    $req = $db->prepare("DELETE from cmd_offre where id=?");
    $req->execute([$_GET['valido']]);
    echo '<script>location.href="pret.php"</script>';
}

if (isset($_GET['validp'])) {
    $req = $db->prepare("DELETE from produit_panier where id=?");
    $req->execute([$_GET['validp']]);
    echo '<script>location.href="pret.php"</script>';
}

if (isset($_GET['validc'])) {
    $req = $db->prepare("DELETE from cmd_collection where id=?");
    $req->execute([$_GET['validc']]);
    echo '<script>location.href="pret.php"</script>';
}


?>