<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="/assets/css/login.css">
    <link rel="shortcut icon" href="assets/images/logol.png" type="image/svg+xml">
</head>

<body>
    <form action="" method="post">
        <div class="wrapper fadeInDown">
            <div id="formContent">
                <!-- Tabs Titles -->
                <a href="login.php"><h2> Connecter </h2></a>
                <h2 class="inactive underlineHover active" >S'inscrire </h2>

                <!-- Login Form -->
                <form method="post">
                    <input type="text" id="nom" class="fadeIn second" name="nom" placeholder="nom complet">
                    <input type="email" id="email" class="fadeIn second" name="email" placeholder="email">
                    <input type="tel" id="tel" class="fadeIn second" name="tel" placeholder="tel">
                    <input type="password" id="password" class="fadeIn third" name="psw" placeholder="password">
                    <input type="submit" class="fadeIn fourth" value="S'inscrire" name="connect">
                </form>

                <!-- Remind Passowrd -->
                <?= $err ?? ""?>
                <div id="formFooter">
                    <a class="underlineHover" href="#">Forgot Password?</a>
                </div>

            </div>
        </div>
    </form>
</body>
</html>
<?php
include_once "inc/db.php";
if (isset($_POST["connect"])) {
$nom=$_POST['nom'];
$email=$_POST['email'];
$psw=$_POST['psw'];
$tel=$_POST['tel'];
if(!empty($nom)&&!empty($email)&&!empty($psw)&&!empty($tel)){
    $req=$db->prepare("INSERT into clien values(?,?,?,?,?)");
    $req->execute([null,$nom,$email,$psw,$tel]);
    header("Location: login.php");
}else{
    $err= '<div class="alert alert-danger" role="alert">S\'il vous plait saisir tout les champes !</div>';
}
}


?>