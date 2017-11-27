<?php
//http://getfit.getenjoyment.net/getfitdb.php?bewerking=selGEB
$servername  = "fdb13.awardspace.net"; // de servernaam die je van je hosting firma hebt ontvangen
$serverpoort = "3306"; //poort
$username    = "2518084_getfit"; // de gebruikersnaam die je van je hosting firma hebt ontvangen
$password    = "getfit2017"; // het paswoord dat je van je hosting firma hebt ontvangen
$dbname      = "2518084_getfit"; // de naam van de databank die je van je hosting firma hebt ontvangen

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname, $serverpoort) or die(mysqli_connect_error());

$bewerking = $_GET['bewerking'];
if ($bewerking == "getGeb") {
    $result = $conn->query("SELECT * FROM tblGebruiker");
    // maak van de inhoud van deze result een json object waarvan
    // ook in android de juiste gegeventypes herkend worden
    $return = getJsonObjFromResult($result);
    mysqli_free_result($result);//maak geheugenresources vrij
    die($return);
    //echo $result;
}
if ($bewerking == "getKalForGeb") {
    //VRAAG KALENDER ID OP VOOR GEBRUIKER_ID
    $idGeb = 1;
    //$tblKalender = "tblKalender";
    $resultGeb = $conn->query("SELECT GEB_KAL_ID FROM tblGebruiker where GEB_ID = $idGeb");
    $returnGeb = getJsonObjFromResult($resultGeb);
    mysqli_free_result($resultGeb);//maak geheugenresources vrij
    $returnGebJson = json_decode($returnGeb, true); // json versie object
    //die($return);
    
    //VRAAG KALENDER OP MET BEPAALD KAL_Kalender_ID
    $idKal = $returnGebJson["data"][0]["GEB_KAL_ID"]; // kalender id
    //$result = $conn->query($id == null ? "SELECT * FROM $tblKalender" : "SELECT * FROM $tblKalender where KAL_Kalender_ID = $id");
    $resultKal = $conn->query("SELECT * FROM tblKalender where KAL_Kalender_ID = $idKal");
    $returnKal = getJsonObjFromResult($resultKal);
    mysqli_free_result($resultKal);// maak geheugenresources vrij :
    $returnKalJson = json_decode($returnKal, true); // json versie object
    
    //VRAAG NAAM OP VAN ROUTINE UIT KALENDER , KAL_ROU_ID
    $idRou = $returnGebJson["data"][0]["GEB_KAL_ID"]; // kalender id
    $resultRou = $conn->query("SELECT * FROM tblRoutine where ROU_ID = $idRou");
    $returnRou = getJsonObjFromResult($resultRou);
    mysqli_free_result($resultRou);//maak geheugenresources vrij
    
    //VRAAG ITEM OP VAN ROUTINE UIT KALENDER , KAL_ROU_ID
    $idRou = $returnGebJson["data"][0]["GEB_KAL_ID"]; // kalender id
    $resultRit = $conn->query("SELECT * FROM tblRoutineItem where RIT_ROU_ID = $idRou");
    $returnRit = getJsonObjFromResult($resultRit);
    mysqli_free_result($resultRit);//maak geheugenresources vrij
    $returnRitJson = json_decode($returnRit, true); // json versie object
    
    //VRAAG OEFENING OP VAN ROUTINE ITEM
    $idOef = $returnRitJson["data"][0]["RIT_OEF_ID"]; // kalender id
    $resultOef = $conn->query("SELECT * FROM tblOefening where OEF_ID = $idOef");
    $returnOef = getJsonObjFromResult($resultOef);
    mysqli_free_result($resultOef);//maak geheugenresources vrij
    
    die($returnOef);
}

function getJsonObjFromResult(&$result)
{
    // de & voor de parameter zorgt er voor dat we de de parameter
    // by reference doorgeven, waardoor deze niet gekopieerd word
    // naar een nieuwe variabele voor deze functie.
    
    $fixed = array();
    
    $typeArray = array(
        MYSQLI_TYPE_TINY,
        MYSQLI_TYPE_SHORT,
        MYSQLI_TYPE_INT24,
        MYSQLI_TYPE_LONG,
        MYSQLI_TYPE_LONGLONG,
        MYSQLI_TYPE_DECIMAL,
        MYSQLI_TYPE_FLOAT,
        MYSQLI_TYPE_DOUBLE
    );
    $fieldList = array();
    // haal de veldinformatie van de velden in deze resultset op
    while ($info = $result->fetch_field()) {
        $fieldList[] = $info;
    }
    // haal de data uit de result en pas deze aan als het veld een
    // getaltype zou moeten bevatten
    while ($row = $result->fetch_assoc()) {
        $fixedRow = array();
        $teller   = 0;
        
        foreach ($row as $key => $value) {
            if (in_array($fieldList[$teller]->type, $typeArray)) {
                $fixedRow[$key] = 0 + $value;
            } else {
                $fixedRow[$key] = $value;
            }
            $teller++;
        }
        $fixed[] = $fixedRow;
    }
    
    // geef een json object terug
    return '{"data":' . json_encode($fixed) . '}';
}
?>
