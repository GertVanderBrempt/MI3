<?php
    $servername = "fdb13.awardspace.net:3306"; // de servernaam die je van je hosting firma hebt ontvangen
    $username   = "2518084_getfit"; // de gebruikersnaam die je van je hosting firma hebt ontvangen
    $password   = "getfit2017"; // het paswoord dat je van je hosting firma hebt ontvangen
    $dbname     = "2518084_getfit"; // de naam van de databank die je van je hosting firma hebt ontvangen
    
    // Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname) or die(mysqli_connect_error());

        $result = $conn -> query("SELECT * FROM tblGebruiker");

        // maak van de inhoud van deze result een json object waarvan
        // ook in android de juiste gegeventypes herkend worden
        $return = getJsonObjFromResult($result);

        // maak geheugenresources vrij :
        mysqli_free_result($result);

echo $result;
   
?>
