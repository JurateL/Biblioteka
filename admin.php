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
    </style>
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
          <a class="nav-link active" aria-current="page" href="pridetiKnyga.php">Pridėti naują knygą</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="pridetiKategorija.php">Pridėti naują kategoriją</a>
        </li>
        <li class="nav-item">
            <?php if(isset($_SESSION['vartotojas'])){
          echo '<a class="nav-link" href="atsijungti.php">Atsijungti</a>';}?>
        </li>
        <li class="nav-item">
       <a class="nav-link disabled" aria-disabled="true"></a>
        </li>
      </ul>
      <form class="d-flex" role="search" action="paieska.php" method="post">
        <input class="form-control me-2" type="search" placeholder="Paieška" aria-label="Search" name="paieska">
        <button class="btn btn-outline-success" type="submit">Paieška</button>
      </form>
    </div>
  </div>
</nav>
<br><br><h5>Knygos</h5>
<?php
require("DBduomenys.php");

try{
    $db= new PDO("mysql:host=$serverioAdresas;dbname=$duombaze", $vartotojoVardas, $slaptazodis);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT knygos.*, kategorija.Pavadinimas AS KategorijosPavadinimas
    FROM knygos
    JOIN kategorija ON knygos.KategorijosID = kategorija.ID";
    $knygos= $db->prepare($sql); 
    $knygos->execute();
    $rezultatas = $knygos->fetchAll(PDO::FETCH_ASSOC);
    echo "<table class='table'>";
    echo "<thead>";
    echo "<tr>";  
    echo "<th scope='col'> Knygos ID </th>";
    echo "<th scope='col'> Pavadinimas </th>";
    echo "<th scope='col'> Santrauka </th>";
    echo "<th scope='col'> ISBN </th>";
    echo "<th scope='col'> Nuotraka </th>";
    echo "<th scope='col'> Puslapių skaičius </th>";
    echo "<th scope='col'> Kategorija </th>";
    echo "<th scope='col'> Trinti </th>";
    echo "<th scope='col'> Redaguoti </th>";
    echo "</tr>"; 
    echo "</thead>";
    foreach($rezultatas as $knyga){
        echo "<tbody>";
        echo "<tr>";  
        echo "<th scope='row'>" . $knyga['KnyguID'] ."</th>";
        echo "<td>" . $knyga['Pavadinimas'] ."</td>";
        echo "<td>" . $knyga['Santrauka'] ."</td>";
        echo "<td>" . $knyga['ISBN'] ."</td>";
        echo '<td><img src="' . $knyga['Nuotraka'] . '" class="card-img-top" alt="" width="150px" height="150px"></td>';
        echo "<td>" . $knyga['psl'] ."</td>";
        echo "<td>" . $knyga['KategorijosPavadinimas'] . "</td>";
        $trinimoNuoroda= "trintiKnyga.php?id=" . $knyga['KnyguID'];
        echo "<td> <a href='$trinimoNuoroda'>Trinti</a> </td>";
        $redagavimoNuoroda = "redaguotiKnyga.php?id=" .$knyga['KnyguID'];
        echo "<td> <a href='$redagavimoNuoroda'>Redaguoti</td>";
        echo "</tr>"; 
        echo "</tbody>";
    }
    echo "</table>";

}catch(PDOEXception $e){
    echo "Nepavyko prisijungti" . $e->getMessage();
}

?>
<br><br><h5>Kategorijos</h5>
<?php
try{
    $db= new PDO("mysql:host=$serverioAdresas;dbname=$duombaze", $vartotojoVardas, $slaptazodis);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql1 = "SELECT * FROM kategorija";
    $kategorijos= $db->prepare($sql1); 
    $kategorijos->execute();
    $rezultatas1 = $kategorijos->fetchAll(PDO::FETCH_ASSOC);
    echo "<table class='table'>";
    echo "<thead>";
    echo "<tr>";  
    echo "<th scope='col'> Kategorijos ID </th>";
    echo "<th scope='col'> Pavadinimas </th>";
    echo "<th scope='col'> Trinti </th>";
    echo "<th scope='col'> Redaguoti </th>";
    echo "</tr>"; 
    echo "</thead>";
    foreach($rezultatas1 as $kategorija){
        echo "<tbody>";
        echo "<tr>";  
        echo "<th scope='row'>" . $kategorija['ID'] ."</th>";
        echo "<td>" . $kategorija['Pavadinimas'] ."</td>";
        $trinimoNuoroda= "trintiKategorija.php?id=" . $kategorija['ID'];
        echo "<td> <a href='$trinimoNuoroda'>Trinti</a> </td>";
        $redagavimoNuoroda = "redaguotiKategorija.php?id=" .$kategorija['ID'];
        echo "<td> <a href='$redagavimoNuoroda'>Redaguoti</td>";
        echo "</tr>"; 
        echo "</tbody>";
    }
    echo "</table>";

}catch(PDOEXception $e){
    echo "Nepavyko prisijungti" . $e->getMessage();
}

?>
    </body>

</html>