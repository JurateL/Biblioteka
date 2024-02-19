<?php 
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
<title>Pagrindinis puslapis</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </head>
    <body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Pagrindinis puslapis</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="registracija.php">Registracija</a>
        </li>
        <li class="nav-item">
            <?php if(isset($_SESSION['vartotojas'])){
          echo '<a class="nav-link" href="atsijungti.php">Atsijungti</a>';}?>
        </li>
        <li class="nav-item">
        <?php if(isset($_SESSION['vartotojas']) && ($_SESSION['tipas']="administratorius")){
          '<a class="nav-link disabled" aria-disabled="true">Grįžti į administratoriaus puslapį</a>';}?>
        </li>
      </ul>
      <form class="d-flex" role="search" action="paieska.php" method="post">
        <input class="form-control me-2" type="search" placeholder="Paieška" aria-label="Search" name="paieska">
        <button class="btn btn-outline-success" type="submit">Paieška</button>
      </form>
    </div>
  </div>
</nav><br><br>
<?php
if(!isset($_SESSION['vartotojas'])){
    header("Location:prisijungimas.php");
}
?>
<?php
require("DBduomenys.php");
try{
    $db= new PDO("mysql:host=$serverioAdresas;dbname=$duombaze", $vartotojoVardas, $slaptazodis);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM knygos JOIN kategorija WHERE KategorijosID=ID";
    $knygos= $db->prepare($sql); 
    $knygos->execute();
    $rezultatas = $knygos->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rezultatas as $knyga) {
        echo '<div class="card" style="width: 18rem;">';
        echo '<img src="' . $knyga['Nuotraka'] . '" class="card-img-top" alt="...">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $knyga['Pavadinimas'] . '</h5>';
        echo '<p class="card-text">' . $knyga['Santrauka'] . '</p>';
        $pridetiPrieMegiamu = "pridetiPrieMegiamu.php?id=" . $knyga['KnyguID'];
        echo '<a href="' . $pridetiPrieMegiamu . '" class="btn btn-primary">Pridėti prie mėgstamiausių</a>';
        echo '</div>';
        $rezervuoti = "rezervuoti.php?id=" . $knyga['KnyguID'];
        echo '<a href="' . $rezervuoti . '" class="btn btn-primary">Rezervuoti</a>';
        
        echo '</div>';
    }
    
}catch(PDOEXception $e){
    echo "Nepavyko prisijungti" . $e->getMessage();
}

?>
    </body>

</html>