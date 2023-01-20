
    <?php

    $file = "assets/pdf/" . $_GET['pdf'];
    header("Content-type: application/pdf");

    header("Content-Length: " . filesize($file));
    readfile($file);
    ?>