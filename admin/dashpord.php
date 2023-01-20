<?php
include_once "sessionAdmin.php";
include_once "incAdmin/hedear.php";
include_once "../inc/db.php";
?>


<body>
    <div class="main">
        <!-- ======================= Cards ================== -->
        <div class="cardBox">
            <div class="card">
                <div>
                    <div class="numbers">
                        <?php
                        $sql = $db->prepare("SELECT count(*) cp from clien");
                        $sql->execute([]);
                        echo $sql->fetch()['cp'];
                        ?>
                    </div>
                    <div class="cardName">Clients</div>
                </div>

                <div class="iconBx">
                    <ion-icon name="person-circle-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div>
                    <div class="numbers">
                        <?php
                        $sql = $db->prepare("SELECT count(*) cp from produit_panier where statut=?");
                        $sql->execute(["valide"]);
                        echo $sql->fetch()['cp'];
                        ?>
                    </div>
                    <div class="cardName">Produits pret</div>
                </div>

                <div class="iconBx">
                    <ion-icon name="cart-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div>
                    <div class="numbers">
                        <?php
                        $sql = $db->prepare("SELECT count(*) cp from produit_panier where statut=?");
                        $sql->execute(["delivered"]);
                        echo $sql->fetch()['cp'];
                        ?>
                    </div>
                    <div class="cardName">Les Commande</div>
                </div>

                <div class="iconBx">
                    <ion-icon name="alarm"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div>
                    <div class="numbers">
                    <?php
                        $sql = $db->prepare("SELECT count(*) cp from product");
                        $sql->execute([]);
                        echo $sql->fetch()['cp'];
                        ?>
                    </div>
                    <div class="cardName">Total de produit</div>
                </div>

                <div class="iconBx">
                <ion-icon name="basket"></ion-icon>
                </div>
            </div>
        </div>

        <!-- ================ Order Details List ================= -->
        <div class="details">
            <div class="recentOrders">
                <div class="cardHeader">
                    <h2>Commandes récentes</h2>
                </div>

                <table >
                    <thead>
                        <tr>
                            <td>Image</td>
                            <td>Clien</td>
                            <td>Nom</td>
                            <td>prix</td>
                            <td>Statut</td>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $sql = $db->prepare("SELECT p.photo , c.nom,p.nom nomp ,pp.statut, p.prix from produit_panier pp inner join clien c on pp.idc=c.id
                        inner join product p on p.idp=pp.idp
                         ORDER BY pp.id desc limit 8 ");
                        $sql->execute();
                        $tab = $sql->fetchAll();
                        foreach ($tab as $val) {
                        ?>
                            <tr>
                                <td>
                                    <div class="imgBx"><img src="../../assets/images/<?= $val['photo'] ?>" alt=""></div>
                                </td>
                                <td><?= $val['nom'] ?> </td>
                                <td><?= $val['nomp'] ?></td>
                                <td><?= $val['prix'] ?>DH</td>
                                <td><span class="status <?= $val['statut'] ?>"><?= $val['statut'] ?></span></td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>

            <!-- ================= New Customers ================ -->
            <div class="recentCustomers">
                <div class="cardHeader">
                    <h2>Clients récents</h2>
                </div>

                <table>
                    <?php
                    $sql = $db->prepare("SELECT * from clien ORDER BY id desc limit 8");
                    $sql->execute([]);
                    $tab = $sql->fetchAll();
                    foreach ($tab as $val) {
                    ?>
                        <tr>
                            <td>
                                <h4><?= $val['nom'] ?></h4>
                            </td>
                        </tr>
                    <?php } ?>


                </table>
            </div>
        </div>
    </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ====== ionicons ======= -->

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>