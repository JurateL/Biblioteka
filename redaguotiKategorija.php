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
        <h2>Kategorijų redagavimas</h2><hr><br>
 
        </h5><br><br>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <input type="hidden" name="id" value="<?php
    if($_SERVER['REQUEST_METHOD']=="GET"){
        echo $_GET['id'];
    }else{
        echo "-";
    }
    ?>"> 
            <h5>Redaguokite kategoriją<?php
        try {
            require("DBduomenys.php");
            $db= new PDO("mysql:host=$serverioAdresas;dbname=$duombaze", $vartotojoVardas, $slaptazodis);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if($_SERVER['REQUEST_METHOD']=="GET"){
            $id1 = $_GET['id'];
            $sql1 = "SELECT Pavadinimas FROM kategorija WHERE ID = :id";
            $pavadinimas = $db->prepare($sql1);
            $pavadinimas->bindParam(":id", $id1);
            $pavadinimas->execute();
            $knyguPav= $pavadinimas->fetchAll(PDO::FETCH_ASSOC);
            foreach($knyguPav as $pav){
                echo "\"" . $pav['Pavadinimas'] . "\"";
            }
        }
        }catch (PDOExeption $e) {
            echo "Nepavyko prisijungti" . $e->getMessage();
        }
            ?><br><br>
            <div class="mb-3">
        <label for="pavadinimas" class="form-label">Pavadinimas</label>
        <input type="text" name="pavadinimas" class="form-control" required>    
        </div>
        <input type="submit" class="btn btn-primary" value="Pakeisti">
        </form><br><br>
            <?php
            try {
            require("DBduomenys.php");
            $db= new PDO("mysql:host=$serverioAdresas;dbname=$duombaze", $vartotojoVardas, $slaptazodis);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if($_SERVER['REQUEST_METHOD']=="POST"){
                $pavadinimas = $_POST['pavadinimas'];
                $id = $_POST['id'];
                $sql = "UPDATE kategorija SET Pavadinimas = :pavadinimas WHERE ID = :id";
              $knygos=$db->prepare($sql);
              $knygos->bindparam(":pavadinimas", $pavadinimas);
              $knygos->bindparam(":id", $id);
              $knygos->execute();
              header("Location:admin.php");
        }
            }catch (PDOExeption $e) {
                echo "Nepavyko prisijungti" . $e->getMessage();
            }
        
        ?>
        
    </body>
</html>