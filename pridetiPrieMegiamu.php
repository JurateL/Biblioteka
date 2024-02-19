<?php
session_start();
if (!$_SESSION['vartotojas']) {
    header("Location: prisijungimas.php");
} else if ($_SESSION['tipas'] != "administratorius") {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Pridėjimas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</head>

<body>
    <?php
    try {
        require("DBduomenys.php");
        $db = new PDO("mysql:host=$serverioAdresas;dbname=$duombaze", $vartotojoVardas, $slaptazodis);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $id = $_GET['id'];
            $VART = $_SESSION['vartotojas'];
            $sql = "INSERT INTO megstamosknygos (VartID, KnygosID) VALUES (:vart, :KnygosID)"; 
            $kurejoID = $db->prepare($sql);
            $kurejoID->bindParam(":vart", $VART);
            $kurejoID->bindParam(":KnygosID", $id);
           
            $kurejoID->execute();
            header("Location: index.php");
        }
    } catch (PDOException $e) {
        echo "Nepavyko prisijungti" . $e->getMessage();
    }
    ?>

</body>

</html>
