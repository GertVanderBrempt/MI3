<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

//http://getfit.getenjoyment.net/getfitdb.php?bewerking=getKalForGeb
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
if ($bewerking == "addGeb") {
        /*if (isset($_POST['GEB_Voornaam']) && 
            isset($_POST['GEB_Familienaam'])&& 
            isset($_POST['GEB_Email'])&& 
            isset($_POST['GEB_Wachtwoord'])) {*/
        if (isset($_GET['GEB_Voornaam']) && 
            isset($_GET['GEB_Familienaam'])&& 
            isset($_GET['GEB_Email'])&& 
            isset($_GET['GEB_Wachtwoord'])) {
            // Controle om o.a. SQL injection te voorkomen.
            //GET
            $GEB_Voornaam = $_GET['GEB_Voornaam'];
            $GEB_Familienaam = $_GET['GEB_Familienaam'];
            $GEB_Email = $_GET['GEB_Email'];
            $GEB_Wachtwoord = $_GET['GEB_Wachtwoord'];
            //POST
            //$GEB_Voornaam = $_POST['GEB_Voornaam'];
            //$GEB_Familienaam = $_POST['GEB_Familienaam'];
            //$GEB_Email = $_POST['GEB_Email'];
            //$GEB_Wachtwoord = $_POST['GEB_Wachtwoord'];
        } else {
            die(json_encode("missing data"));
        }

        // product toevoegen

       
        if ($conn -> query("insert into tblGebruiker (GEB_Voornaam, GEB_Familienaam, GEB_Email, GEB_Wachtwoord) values('"
        .$GEB_Voornaam."','".$GEB_Familienaam."','".$GEB_Email."','".$GEB_Wachtwoord."')") === TRUE) { // into $t
            die(json_encode("Record added successfully"));
        } else {
            die(json_encode("Error adding record: " . $conn -> error));
        }
}
if ($bewerking == "addRou") {
    if (isset($_GET['ROU_Naam']) && 
        isset($_GET['ROU_GEB_ID'])){
        $ROU_Naam = $_GET['ROU_Naam'];
        $ROU_GEB_ID = $_GET['ROU_GEB_ID'];
    } else {
        die(json_encode("missing data"));
    }
    
    if ($conn -> query("insert into tblRoutine (ROU_Naam, ROU_GEB_ID) values('"
        .$ROU_Naam."','".$ROU_GEB_ID."')") === TRUE) { // into $t
        $resultGeb = $conn->query("SELECT * FROM tblGebruiker where GEB_ID = $ROU_GEB_ID");
        $returnGeb = getJsonObjFromResult($resultGeb);
        mysqli_free_result($resultGeb);// maak geheugenresources vrij :
        $returnGebJson = json_decode($returnGeb, true); // json versie object
        $naamGeb = $returnGebJson["data"][0]["GEB_Voornaam"];
        die(json_encode("Record added successfully for $naamGeb"));
    } else {
        die(json_encode("Error adding record: " . $conn -> error));
    }
}
if ($bewerking == "getKalForGeb") {
    $idGeb = 1;//GEBRUIKER ID = KALENDER ID
    
    //VRAAG KALENDER ITEMS OP MET BEGRUIKER ID
    $resultKit = $conn->query("SELECT * FROM tblKalenderItem where KIT_GEB_ID = $idGeb");
    $returnKit = getJsonObjFromResult($resultKit);
    mysqli_free_result($resultKit);// maak geheugenresources vrij :
    $returnKitJson = json_decode($returnKit, true); // json versie object
    
    //VRAAG NAAM OP VAN ROUTINE UIT KALENDER , KAL_ROU_ID => MAX is 1 element (verwijderen als aangepast ?)
    $idRou = $returnKitJson["data"][0]["KIT_ROU_ID"]; // routine id
    $resultRou = $conn->query("SELECT * FROM tblRoutine where ROU_ID = $idRou");
    $returnRou = getJsonObjFromResult($resultRou);
    mysqli_free_result($resultRou);//maak geheugenresources vrij
    
    //VRAAG ITEM OP VAN ROUTINE UIT KALENDER , KAL_ROU_ID => MAX is MEERDERE elementen ! lijst
    $idRou = $returnKitJson["data"][0]["KIT_ROU_ID"]; // routine id
    $resultRit = $conn->query("SELECT * FROM tblRoutineItem where RIT_ROU_ID = $idRou");
    $returnRit = getJsonObjFromResult($resultRit);
    mysqli_free_result($resultRit);//maak geheugenresources vrij
    $returnRitJson = json_decode($returnRit, true); // json versie object
    
    $oefeningen = [];
    //VRAAG OEFENING OP VAN ROUTINE ITEM => MAX is 1 element
    foreach($returnRitJson["data"] as $oef){
    $idOef = $oef["RIT_OEF_ID"]; // oef id
    $resultOef = $conn->query("SELECT * FROM tblOefening where OEF_ID = $idOef");
    $returnOef = getJsonObjFromResult($resultOef);
    mysqli_free_result($resultOef);//maak geheugenresources vrij
    $returnOefJson = json_decode($returnOef, true); // json versie object
    array_push($oefeningen, $returnOefJson["data"]);
    }
    
    //die($returnOef);
    $oefeningenJson = '{"oefeningen":' . json_encode($oefeningen) . '}';
    die($oefeningenJson);
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
