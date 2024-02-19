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
    .form-control, .form-select{
        width:300px;
    }
  </style>
    </head>
    <body>
    <a class="btn btn-outline-dark" href="admin.php" role="button">Grįžti</a><br><br>
    <h3>Pridėkite naują knygą</h3><br><br>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <div class="mb-3">
        <label for="pavadinimas" class="form-label">Pavadinimas</label>
        <input type="text" name="pavadinimas" class="form-control" required>    
        </div>
        <div class="mb-3">
            <label for="Santrauka">Santrauka</label>
        <textarea name="Santrauka" id="" cols="20" rows="5" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
        <label for="ISBN" class="form-label">ISBN</label>
        <input type="number" name="ISBN" class="form-control" required>  
        </div>
        <div class="mb-3">
        <label for="Nuotraka" class="form-label">Nuotrakos nuoroda</label>
        <input type="text" name="Nuotraka" class="form-control" required>  
        </div>
        <div class="mb-3">
        <label for="psl" class="form-label">Puslapių skaičius</label>
        <input type="number" name="psl" class="form-control" required>  
        </div>
        <div class="mb-3">
        <label for="KategorijosID">KategorijosID</label>
        <select class="form-select" aria-label="Default select example" name="KategorijosID" required>
    <option selected></option>
    <?php
    try {
        require("DBduomenys.php");
        $db = new PDO("mysql:host=$serverioAdresas;dbname=$duombaze", $vartotojoVardas, $slaptazodis);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql2 = "SELECT * FROM kategorija"; // Corrected SQL query
        $kategorijos = $db->prepare($sql2);
        $kategorijos->execute();
        $rezultatas2 = $kategorijos->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rezultatas2 as $kategorija) {
            echo '<option value="' . $kategorija['ID'] . '">' . $kategorija['Pavadinimas'] . '</option>';
        }
    } catch (PDOException $e) {
        echo "Nepavyko gauti kategorijų: " . $e->getMessage();
    }
    ?>
</select>

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
            $santrauka = $_POST['Santrauka'];
            $ISBN = $_POST['ISBN'];
            $nuotraka = $_POST['Nuotraka'];
            $psl = $_POST['psl'];
            $kategorijosID = $_POST['KategorijosID'];
            $sql= "INSERT INTO knygos(Pavadinimas, Santrauka, ISBN, Nuotraka, psl, KategorijosID) 
            VALUES(:pavadinimas, :Santrauka, :ISBN, :Nuotraka, :psl, :KategorijosID)";
            $knygos=$db->prepare($sql);
            $knygos->bindparam(":pavadinimas", $pavadinimas);
            $knygos->bindparam(":Santrauka", $santrauka);
            $knygos->bindparam(":ISBN", $ISBN);
            $knygos->bindparam(":Nuotraka", $nuotraka);
            $knygos->bindparam(":psl", $psl);
            $knygos->bindparam(":KategorijosID", $kategorijosID);
            $knygos->execute();
            header("Location:admin.php");
        }
            }catch (PDOExeption $e) {
                echo "Nepavyko prisijungti" . $e->getMessage();
            }       
        ?>
    </body>
</html>