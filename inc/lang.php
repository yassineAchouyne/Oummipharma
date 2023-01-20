<?php
if (empty($_SESSION['lang']) || $_SESSION['lang'] == "fr") {
    $_SESSION['lang'] = "fr";
} else {
    $_SESSION['lang'] = "ar";
}
$lang=$_SESSION['lang'];
if($lang=="fr"){
    $img="/assets/images/morocco.png";
    $lien="?lang=ar";
    $titre="Livraison gratuite dans la ville d'Agadir";
    $titreH1="Révéler le";
    $home="Home";
    $collection="Collection";
    $pr="Produits";
    $offre="Offre";
    $blog="Blog";
    $titreH2="Beauté de la peau";
    $descriptionH="Fabriqués à partir d'ingrédients propres et non toxiques, nos produits sont conçus pour tout le monde.";
    $partir="À partir de";
    $achter="Achetez maintenant";
    $produit="Nos Produits";
    $Tousproduit="tous les produits";
    $moins50="Moins de 50.00 DH";
    $qestion="Pourquoi acheter avec Oummipharma ?";
    $titreQ1="PUR garanti";
    $titreQ2="Complètement sans cruauté";
    $titreQ3="Approvisionnement en ingrédients";
    $desc1="Toutes les formulations Grace adhèrent à des normes de pureté strictes et ne contiendront jamais d'ingrédients agressifs ou toxiques";
    $desc2="Toutes les formulations Grace adhèrent à des normes de pureté strictes et ne contiendront jamais d'ingrédients agressifs ou toxiques";
    $desc3="Toutes les formulations Grace adhèrent à des normes de pureté strictes et ne contiendront jamais d'ingrédients agressifs ou toxiques";
    $Toffre="OFFRE SPÉCIALE";
    $Valable="Valable à";
    $jour="jour";
    $Obtenez="Obtenez seulement";
    $titreBlog="Plus à découvrir";
    $footer="Bienvenue à Oummipharma";
    $mad="DH";
}else{
    $img="/assets/images/france.png";
    $lien="?lang=fr";
    $titre="التوصيل المجاني في مدينة أكادير";
    $titreH1="تكشف عن";
    $titreH2="جمال البشرة";
    $home="الرئيسية";
    $collection="مجموعة";
    $pr="منتجات";
    $offre="عرض";
    $blog="مدونة";
    $descriptionH="مصنوعة من مكونات نظيفة وغير سامة ، منتجاتنا مصممة للجميع.";
    $partir="ابتداء من";
    $achter="اشتري الآن";
    $produit="منتجاتنا";
    $Tousproduit="كل المنتوجات";
    $moins50="أقل من 50.00 درهم";
    $qestion="لماذا تشتري من اوميفارما?";
    $titreQ1="نقي مضمون";
    $titreQ2="تماما خالية من القسوة";
    $titreQ3="مصادر المكونات";
    $desc1="تلتزم جميع تركيبات Grace بمعايير نقاء صارمة ولن تحتوي أبدًا على مكونات قاسية أو سامة";
    $desc2="تلتزم جميع تركيبات Grace بمعايير نقاء صارمة ولن تحتوي أبدًا على مكونات قاسية أو سامة";
    $desc3="تلتزم جميع تركيبات Grace بمعايير نقاء صارمة ولن تحتوي أبدًا على مكونات قاسية أو سامة";
    $Toffre="عرض خاص";
    $Valable="صالح الى ";
    $jour="يوم";
    $Obtenez="احصل عليه فقط ب";
    $titreBlog="لاكتشاف المزيد";
    $footer="مرحبًا بكم في اوميفارما";
    $mad="درهم";
}
?>
