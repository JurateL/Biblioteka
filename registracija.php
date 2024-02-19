<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
<title>Registracija</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
   <style>
    body{
        margin: auto;
        width: 300px;
    }
    h5{
        text-align:center;
    }
   </style>

</head>
    <body>
        <h5>Registracija</h5><br><br>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Vartotojo vardas</label>
    <input type="text" class="form-control" name="vartvardas" required>
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Vardas</label>
    <input type="text" class="form-control" name="vardas" required>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Pavardė</label>
    <input type="text" class="form-control" name="pavarde" required>
  </div>
  <div class="mb-3">
    <label for="tipas">Vartotojo tipas</label>
    <select class="form-select" aria-label="Default select example" name="tipas" required>
  <option selected></option>
  <option value="administratorius">Administratorius</option>
  <option value="skaitytojas">Skaitytojas</option>
</select>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Slaptažodis</label>
    <input type="password" class="form-control" name="slaptazodis" required>
  </div>
  <button type="submit" class="btn btn-primary">Registruotis</button>
</form>

<?php
require("DBduomenys.php");
try{
    $db= new PDO("mysql:host=$serverioAdresas;dbname=$duombaze", $vartotojoVardas, $slaptazodis);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $vartvardas = $_POST['vartvardas'];
        $vardas = $_POST['vardas'];
        $pavarde = $_POST['pavarde'];
        $slapt = $_POST['slaptazodis'];
        $sifrtuoasSlapt = password_hash("$slapt", PASSWORD_DEFAULT);
        $tipas = $_POST['tipas'];
    $sql = "SELECT * FROM vartotojai WHERE VartotojoVardas= :vartvardas";
    $vardai= $db->prepare($sql);
    $vardai->bindParam(":vartvardas", $vardas);  
    $vardai->execute();
    $rezultatas = $vardai->fetchAll(PDO::FETCH_ASSOC);
    if(!$rezultatas){  
    $sql1= "INSERT INTO vartotojai(VartotojoVardas, Vardas, Pavarde, Slaptazodis, Tipas)
    VALUES(:vartvardas, :vardas, :pavarde, :slapt, :tipas)";
    $vartotojai=$db->prepare($sql1);
    $vartotojai->bindParam("vartvardas", $vartvardas);
    $vartotojai->bindParam("vardas", $vardas);
    $vartotojai->bindParam("pavarde", $pavarde);
    $vartotojai->bindParam("slapt", $sifrtuoasSlapt);
    $vartotojai->bindParam("tipas", $tipas);
    $vartotojai->execute();
    echo "<p><strong><em>Sėkmingai užsiregistravote!<strong><em></p>"; 
    echo "<a href='prisijungimas.php' class='prisijungti'>Prisijungti</a>";
}
    }

}catch(PDOEXception $e){
    echo "Nepavyko prisijungti" . $e->getMessage();
}

?>



    </body>
</html>