<?php
session_start();
if(!$_SESSION['vartotojas']){
    header("Location:prisijungimas.php");
}else if($_SESSION['tipas']!="administratorius"){
    header("Location:index.php");
} 
?>
<!DOCTYPE html>
<html>
    <head>
    <title>Pagrindinis puslapis</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<style>
    body{
        margin: auto;
        padding: 10px;
    }
    .form-control{
        width:300px;
    }
  </style>
    </head>
    <body>
    <a class="btn btn-outline-dark" href="admin.php" role="button">Grįžti</a><br><br>
    <h3>Pridėkite filmo kategoriją</h3><br><br>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <div class="mb-3">
        <label for="pavadinimas" class="form-label">Kategorijos pavadinimas</label>
        <input type="text" name="pavadinimas" class="form-control">    
        </div>
        <input type="submit" class="btn btn-primary" value="Pridėti">
    </form>
        <?php
         try {
            require("DBduomenys.php");
            $db= new PDO("mysql:host=$serverioAdresas;dbname=$duombaze", $vartotojoVardas, $slaptazodis);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if($_SERVER['REQUEST_METHOD']== "POST"){
            $pavadinimas = $_POST['pavadinimas'];
            $sql= "INSERT INTO kategorija(Pavadinimas) VALUES(:pavadinimas)";
            $kategorijos=$db->prepare($sql);
            $kategorijos->bindparam(":pavadinimas", $pavadinimas);
            $kategorijos->execute();
            header("Location:admin.php");
        }
            }catch (PDOExeption $e) {
                echo "Nepavyko prisijungti" . $e->getMessage();
            }       
        ?>
    </body>
</html>