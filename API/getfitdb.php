<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
//header('Content-Type: application/json');
//http://getfit.getenjoyment.net/getfitdb.php?bewerking=getKalForGeb

$servername  = "fdb13.awardspace.net"; // de servernaam  van de host
$serverpoort = "3306";                 // de serverpoort van de host
$username    = "2518084_getfit"; // de gebruikersnaam voor de database
$password    = "getfit2017";     // het paswoord      voor de database
$dbname      = "2518084_getfit"; // de naam van de database

// MAAK EEN CONNECTIE MET DE DATABASE
$conn = mysqli_connect($servername, $username, $password, $dbname, $serverpoort) or die(mysqli_connect_error());

// POST(GET) code

// POSTvars voor volley in native Android
$body = file_get_contents('php://input');
$postvars = json_decode($body, true);

$bewerking = $postvars["bewerking"];
//nodig voor api functies
//-addGeb
$GEB_Voornaam    = $postvars['GEB_Voornaam'];
$GEB_Familienaam = $postvars['GEB_Familienaam'];
$GEB_Email       = $postvars['GEB_Email'];       //-checkLogin
$GEB_Wachtwoord  = $postvars['GEB_Wachtwoord'];  //-checkLogin
//-addRou
$ROU_Naam   = $postvars['ROU_Naam'];
$ROU_GEB_ID = $postvars['ROU_GEB_ID'];
//-delRou
$ROU_ID   = $postvars['ROU_ID'];

// POST voor ajax
if(isset($_POST['bewerking'])){
    $bewerking = $_POST['bewerking'];
}
//nodig voor api functies
//-addGeb
if (isset($_POST['GEB_Voornaam']) && 
    isset($_POST['GEB_Familienaam'])&& 
    isset($_POST['GEB_Email'])&& 
    isset($_POST['GEB_Wachtwoord'])) {
    //zet waardes in variabelen
    $GEB_Voornaam = $_POST['GEB_Voornaam'];
    $GEB_Familienaam = $_POST['GEB_Familienaam'];
    $GEB_Email = $_POST['GEB_Email'];
    $GEB_Wachtwoord = $_POST['GEB_Wachtwoord'];
}
//-checkLogin
if (isset($_POST['GEB_Email'])&& 
    isset($_POST['GEB_Wachtwoord'])) {
    //zet waardes in variabelen
    $GEB_Email = $_POST['GEB_Email'];
    $GEB_Wachtwoord = $_POST['GEB_Wachtwoord'];
}
//-addRou
if (isset($_POST['ROU_Naam']) && 
    isset($_POST['ROU_GEB_ID'])){
	//zet waardes in variabelen
    $ROU_Naam = $_POST['ROU_Naam'];
    $ROU_GEB_ID = $_POST['ROU_GEB_ID'];
} 
//-delRou
if (isset($_POST['ROU_ID'])){
	//zet waardes in variabelen
    $ROU_ID = $_POST['ROU_ID'];
} 

// GET voor tests 
//if($bewerking == null || $bewerking == ''){
	if(isset($_GET['bewerking'])){
    	$bewerking = $_GET['bewerking'];
	}
//}
//nodig voor api functies
//-addGeb
if (isset($_GET['GEB_Voornaam']) && 
    isset($_GET['GEB_Familienaam'])&& 
    isset($_GET['GEB_Email'])&& 
    isset($_GET['GEB_Wachtwoord'])) {
    //zet waardes in variabelen
    $GEB_Voornaam = $_GET['GEB_Voornaam'];
    $GEB_Familienaam = $_GET['GEB_Familienaam'];
    $GEB_Email = $_GET['GEB_Email'];
    $GEB_Wachtwoord = $_GET['GEB_Wachtwoord'];
}
//-checkLogin
if (isset($_GET['GEB_Email'])&& 
    isset($_GET['GEB_Wachtwoord'])) {
    //zet waardes in variabelen
    $GEB_Email = $_GET['GEB_Email'];
    $GEB_Wachtwoord = $_GET['GEB_Wachtwoord'];
}
//-addRou
if (isset($_GET['ROU_Naam']) && 
    isset($_GET['ROU_GEB_ID'])){
	//zet waardes in variabelen
    $ROU_Naam = $_GET['ROU_Naam'];
    $ROU_GEB_ID = $_GET['ROU_GEB_ID'];
} 
//-delRou
if (isset($_GET['ROU_ID'])){
	//zet waardes in variabelen
    $ROU_ID = $_GET['ROU_ID'];
} 
// log connectie in db
/*$logdata = "postvars:".var_dump($postvars);
$logdata .= " / ip:".$_SERVER['REMOTE_ADDR'];
$logdata .= " / url:".$_SERVER['REQUEST_URI'];
$logdata .= " / time:".time();
$resultConn = $conn -> query("insert into tblConnectie (CON_DATA) values('".$logdata."')");
$returnConn = getJsonObjFromResult($resultConn);
mysqli_free_result($resultConn);//maak geheugenresources vrij
*/
// API FUNCTIES

if ($bewerking == "getGeb") { // VRAAG EEN LIJST OP VAN GEBRUIKERS EN HUN INFO
    $result = $conn->query("SELECT * FROM tblGebruiker");
    $return = getJsonObjFromResult($result);// maakt van de inhoud van deze result een json object waarvan ook in android de juiste gegeventypes herkend worden
    mysqli_free_result($result);//maak geheugenresources vrij
    die($return);
}
if ($bewerking == "checkLogin") { //KIJK NA OF LOGIN INFO CORRECT IS
    $result = $conn->query("SELECT GEB_Wachtwoord, GEB_Voornaam FROM tblGebruiker WHERE GEB_Email = '$GEB_Email'"); 
    $return = getJsonObjFromResult($result);// maakt van de inhoud van deze result een json object waarvan ook in android de juiste gegeventypes herkend worden
    mysqli_free_result($result);//maak geheugenresources vrij
    $returnLoginJson = json_decode($return, true); // json versie object
    $wachtwoord = $returnLoginJson["data"][0]["GEB_Wachtwoord"];
    if ($wachtwoord === $GEB_Wachtwoord ) {
        //die($return);//wachtwoord moet niet meegestuurd worden
        $myJsonObj = (object)array("GEB_Voornaam" => $returnLoginJson["data"][0]["GEB_Voornaam"]);
        die(addJsonData("200",[$myJsonObj]));
    } else {
        die(addJsonData("400","login failed."));
    }
}

if ($bewerking == "addGeb") { // MAAK EEN GEBRUIKER AAN : registeer
    if ($GEB_Voornaam && 
        $GEB_Familienaam && 
        $GEB_Email && 
        $GEB_Wachtwoord ) {
        // Controle om o.a. SQL injection te voorkomen.
    } else {
        die(addJsonData("400","niet alle velden werden ingevuld."));//json_encode("missing data"));
    }

       
    if ($conn->query("insert into tblGebruiker (GEB_Voornaam, GEB_Familienaam, GEB_Email, GEB_Wachtwoord) values('"
        .$GEB_Voornaam."','".$GEB_Familienaam."','$GEB_Email','".$GEB_Wachtwoord."')") === TRUE) { // into $t
        die(addJsonData("200","je werd met success geregistreerd."));////json_encode("Record added successfully"));
    } else {
        die(addJsonData("400","er werd een probleem vastgesteld tijdens je registratie. ERROR: " . $conn -> error));//json_encode("Error adding record: " . $conn -> error));
    }
}

if ($bewerking == "addRou") { //MAAK EEN ROUTINE AAN (MET NAAM) (VOOR GEBRUIKER)
    if ($ROU_Naam && 
        $ROU_GEB_ID){
        // Controle om o.a. SQL injection te voorkomen.
    } else {
        die(addJsonData("400","missing data"));
    }
    
    if ($conn -> query("insert into tblRoutine (ROU_Naam, ROU_GEB_ID) values('"
        .$ROU_Naam."','".$ROU_GEB_ID."')") === TRUE) { // into $t

    	//CHECK LINK MET GEBRUIKER ID : TOON VOOR WELKE GEBRUIKER DE ROUTINE IS TOEGEVOEGD
        $resultGeb = $conn->query("SELECT * FROM tblGebruiker where GEB_ID = $ROU_GEB_ID");
        $returnGeb = getJsonObjFromResult($resultGeb);
        mysqli_free_result($resultGeb); // maak geheugenresources vrij
        $returnGebJson = json_decode($returnGeb, true); // json versie object
        $naamGeb = $returnGebJson["data"][0]["GEB_Voornaam"];

        die(addJsonData("400","Record added successfully for $naamGeb"));
    } else {
        die(addJsonData("400","Error adding record: " . $conn -> error));
    }
}

if ($bewerking == "delRou") { //VERWIJDER EEN ROUTINE
    if ($ROU_ID){
        // Controle om o.a. SQL injection te voorkomen.
    } else {
        die(addJsonData("400","missing data"));
    }
    if ($conn -> query("delete FROM tblRoutine where ROU_ID = $id") === TRUE) { // FROM $t
        die(addJsonData("400","Record deleted successfully"));
    } else {
        die(addJsonData("400","Error deleting record: " . $conn -> error));
    }
}

if ($bewerking == "getKalForGeb") {
    $idGeb = 1;//GEBRUIKER ID = KALENDER ID
    
    //VRAAG KALENDER ITEMS OP MET BEGRUIKER ID
    $resultKit = $conn->query("SELECT * FROM tblKalenderItem where KIT_GEB_ID = $idGeb");
    $returnKit = getJsonObjFromResult($resultKit);
    mysqli_free_result($resultKit);// maak geheugenresources vrij
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
function addJsonData($status,$data){
 return '{"status":'.$status.',"data":'.json_encode($data).'}';
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
    return addJsonData("200",$fixed);
}
?>
