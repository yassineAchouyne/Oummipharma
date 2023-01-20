<?php
session_start();
include "../inc/db.php";
if (isset($_POST['connect'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $sql = $db->prepare("SELECT * from `admin` where email=:email and paswworde=:pas");
    $sql->execute([":email" => $email, ":pas" => $pass]);
    $cp = $sql->rowCount();
    $admin = $sql->fetch();
    if ($cp != 0) {
        $_SESSION['id_admin'] = $admin['id_admin'];
        header("Location:dashpord.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se Connecter</title>
    <link rel="stylesheet" href="/assets/css/login.css">
    
</head>

<body>
    <form action="" method="post">
        <div class="wrapper fadeInDown">
            <div id="formContent">
                <!-- Tabs Titles -->
                <h2 class="active"> Connecter </h2>

                <!-- Login Form -->
                <form>
                    <input type="email" id="email" class="fadeIn second" name="email" placeholder="email">
                    <input type="password" id="password" class="fadeIn third" name="password" placeholder="password">
                    <input type="submit" name="connect" class="fadeIn fourth" value="Se Connecter">
                </form>

            </div>
        </div>
    </form>
</body>

</html>
