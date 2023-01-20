<?php session_start() ?>
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
                <h2 class="active"> Connecter </h2>
                <a href="singin.php">
                    <h2 class="inactive underlineHover">S'inscrire </h2>
                </a>

                <!-- Login Form -->
                <form>
                    <input type="email" id="email" class="fadeIn second" name="email" placeholder="email">
                    <input type="password" id="password" class="fadeIn third" name="psw" placeholder="password">
                    <input type="submit" name="connect" class="fadeIn fourth" value="Se Connecter">
                </form>
                
                <!-- Remind Passowrd -->
                <div id="formFooter">
                    <a class="underlineHover" href="#">Forgot Password?</a>
                </div>

            </div>
        </div>
    </form>
</body>

</html>
<?php
include "inc/db.php";
if (isset($_POST["connect"])) {
    $email = $_POST['email'];
    $psw = $_POST['psw'];

    $sql = $db->prepare("SELECT * from clien where email=:email and passworde=:pas");
    $sql->execute([":email" => $email, ":pas" => $psw]);
    $cp = $sql->rowCount();
    $clien = $sql->fetch();
    if ($cp != 0) {
        // $a = $clien['id'];
        $_SESSION['id_clien'] = $clien['id'];
        // header("Location:inc/session.php?ses=$a");
        // $url=$_SESSION['url'];
        // echo "test";
        header("Location: index.php");
    } else {
        echo  '<div class="err err-d" role="alert">Il n\'y a pas d\'utilisateur avec cette information!</div>';
    }
}
?>