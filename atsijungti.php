<?php 
session_start();
?>
<html>
    <head></head>
    <body>
        <?php
            session_unset();
            session_destroy();
            echo "atsijungiau";
            header("Location:index.php");
        ?>
 
    </body>
</html>