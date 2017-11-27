<?php
    $servername = "fdb13.awardspace.net"; // de servernaam die je van je hosting firma hebt ontvangen
    $serverpoort = "3306"; //poort
    $username   = "2518084_getfit"; // de gebruikersnaam die je van je hosting firma hebt ontvangen
    $password   = "getfit2017"; // het paswoord dat je van je hosting firma hebt ontvangen
    $dbname     = "2518084_getfit"; // de naam van de databank die je van je hosting firma hebt ontvangen
    
    // Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname, $serverpoort) or die(mysqli_connect_error());

        $result = $conn -> query("SELECT * FROM tblGebruiker");

        // maak van de inhoud van deze result een json object waarvan
        // ook in android de juiste gegeventypes herkend worden
        $return = getJsonObjFromResult($result);

        // maak geheugenresources vrij :
        mysqli_free_result($result);
        die($return);

//echo $result;
   
function getJsonObjFromResult(&$result){
    // de & voor de parameter zorgt er voor dat we de de parameter
    // by reference doorgeven, waardoor deze niet gekopieerd word
    // naar een nieuwe variabele voor deze functie.

    $fixed = array();
    
    $typeArray = array(
                    MYSQLI_TYPE_TINY, MYSQLI_TYPE_SHORT, MYSQLI_TYPE_INT24,    
                    MYSQLI_TYPE_LONG, MYSQLI_TYPE_LONGLONG,
                    MYSQLI_TYPE_DECIMAL, 
                    MYSQLI_TYPE_FLOAT, MYSQLI_TYPE_DOUBLE );
    $fieldList = array();
    // haal de veldinformatie van de velden in deze resultset op
    while($info = $result->fetch_field()){
        $fieldList[] = $info;
    }
    // haal de data uit de result en pas deze aan als het veld een
    // getaltype zou moeten bevatten
    while ($row = $result -> fetch_assoc()) {
        $fixedRow = array();
        $teller = 0;

        foreach ($row as $key => $value) {
            if (in_array($fieldList[$teller] -> type, $typeArray )) {
                $fixedRow[$key] = 0 + $value;
            } else {
                $fixedRow[$key] = $value;
            }
            $teller++;
        }
        $fixed[] = $fixedRow;
    }

    // geef een json object terug
    return '{"data":'.json_encode($fixed).'}';
}
?>
