<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
    <title> Prisijungimas </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
   <style>
        body{
            margin: auto;
            width: 30%;
            padding-top: 50px;
            text-align: center;
        }
    </style>
    </head>
    <body>
        <h3>Prisijunkite</h3><br><br>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <div class="mb-3">
        <label for="VartotojoVardas" class="form-label">Vartotojo vardas</label>
        <input type="text" name="VartotojoVardas" class="form-control" required>    
        </div>
        <div class="mb-3">
        <label for="Slaptazodis" class="form-label">Slaptažodis</label>
        <input type="password" name="Slaptazodis" class="form-control" required>  
        </div>
        <div class="mb-3">
        </div>
        <input type="submit" class="btn btn-primary" value="prisijungti">
    </form>
    <?php
     require("DBduomenys.php");
            try {
            $db= new PDO("mysql:host=$serverioAdresas;dbname=$duombaze", $vartotojoVardas, $slaptazodis);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if($_SERVER['REQUEST_METHOD']=="POST"){
                $vardas = $_POST['VartotojoVardas'];
                $slapt = $_POST['Slaptazodis'];
                $sifrtuoasSlapt = password_hash("$slapt", PASSWORD_DEFAULT);
            $sql = "SELECT * FROM vartotojai WHERE VartotojoVardas= :vardas";
            $vardai= $db->prepare($sql);
            $vardai->bindParam(":vardas", $vardas);  
            $vardai->execute();
            $rezultatas = $vardai->fetchAll(PDO::FETCH_ASSOC);
            if(count($rezultatas)> 0){ 
                $gautasSlapt = $rezultatas[0]['Slaptazodis'];
                if(password_verify($slapt, $gautasSlapt)){
                    echo "<p><strong><em>Sėkmingai prisijugėte!<strong><em></p>"; 
                    $_SESSION['vartotojas'] = $rezultatas[0]['VartotojoID'];
                    $_SESSION['tipas'] = $rezultatas[0]['Tipas'];
                    if($_SESSION['tipas']== "administratorius"){
                        header("Location:admin.php");
                    }else{
                        header("Location:index.php");
                    }
                }
        }
    }
            }catch (PDOExeption $e) {
                echo "Nepavyko prisijungti" . $e->getMessage();
            }
 
            ?>
    </body>
</html>