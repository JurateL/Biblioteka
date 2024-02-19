<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
    <title>Paieška</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<style>
        body{
        margin: auto;
        padding: 10px;
            }
    </style>
    </head>
    <body>
        <?php
          try {
            require("DBduomenys.php");
            $db= new PDO("mysql:host=$serverioAdresas;dbname=$duombaze", $vartotojoVardas, $slaptazodis);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                $rezultatas = $_POST['paieska'];
                $sql = "SELECT * FROM knygos WHERE Pavadinimas LIKE '%$rezultatas%'";
                $rezultatas1 = $db->query($sql);
                $paieska= $rezultatas1->fetchAll(PDO::FETCH_ASSOC);
                echo '<a class="btn btn-outline-dark" href="admin.php" role="button">Grįžti</a><br><br>';
                echo "<h3> Paieškos rezultatai: </h3>";
                echo "<ul class='list-group'>";
                foreach($paieska as $radau){
                    $ID = $radau['KnyguID'];
                    echo "<a href='index.php?KnyguID =$ID'>";
                    echo "<li class='list-group-item'>" . $radau['Pavadinimas'] . "</li>";          
                }
            }
        }catch (PDOExeption $e) {
            echo "Nepavyko prisijungti" . $e->getMessage();
        }    
        
        ?>
    </body>
</html>