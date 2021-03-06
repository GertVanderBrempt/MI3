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
$GEB_ID          = $postvars['GEB_ID']; //-getKalForGeb
$KIT_DAG         = $postvars['KIT_DAG']; //-getKalForGebOnDag
$KIT_ID          = $postvars['KIT_ID']; //-delKit
//-addRou
$ROU_Naam   = $postvars['ROU_Naam'];
$ROU_GEB_ID = $postvars['ROU_GEB_ID'];
//-delRou
$ROU_ID   = $postvars['ROU_ID'];
//-getInfoOef
$OEF_ID          = $postvars['OEF_ID'];
$OEF_Titel       = $postvars['OEF_Titel'];
$OEF_Spier       = $postvars['OEF_Spier'];
$OEF_Beschrijving = $postvars['OEF_Beschrijving'];
$OEF_Afbeelding  = $postvars['OEF_Afbeelding'];
$OEF_AantalCal   = $postvars['OEF_AantalCal'];

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
//-delRou + getOefForRou
if (isset($_POST['ROU_ID'])){
	//zet waardes in variabelen
    $ROU_ID = $_POST['ROU_ID'];
} 
//-getKalForGeb en -getGeb
if (isset($_POST['GEB_ID'])){
        //zet waardes in variabelen
    $GEB_ID = $_POST['GEB_ID'];
}
//-getKalForGebOnDag
if (isset($_POST['KIT_DAG'])){
        //zet waardes in variabelen
    $KIT_DAG = $_POST['KIT_DAG'];
}
//-delKit
if (isset($_POST['KIT_ID'])){
        //zet waardes in variabelen
    $KIT_ID = $_POST['KIT_ID'];
}
//-getInfoOef
if (isset($_POST['OEF_ID'])){
        //zet waardes in variabelen
    $OEF_ID = $_POST['OEF_ID'];
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
//-getKalForGeb
if (isset($_GET['GEB_ID'])) {
   $GEB_ID = $_GET['GEB_ID'];
}

//-getKalForGebOnDag
if (isset($_GET['KIT_DAG'])) {
   $KIT_DAG = $_GET['KIT_DAG'];
}

//-delKit
if (isset($_GET['KIT_ID'])) {
   $KIT_ID = $_GET['KIT_ID'];
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
//-delRou + getOefForRou
if (isset($_GET['ROU_ID'])){
	//zet waardes in variabelen
    $ROU_ID = $_GET['ROU_ID'];
} 
//-getInfoOef
if (isset($_GET['OEF_ID'])){
	//zet waardes in variabelen
    $OEF_ID = $_GET['OEf_ID'];
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

if ($bewerking == "getGeb") { // VRAAG EEN LIJST OP VAN GEBRUIKER(S) EN HUN INFO
    $result = $conn->query("SELECT GEB_Voornaam, GEB_Familienaam FROM tblGebruiker WHERE GEB_ID = $GEB_ID");
    $return = getJsonObjFromResult($result);// maakt van de inhoud van deze result een json object waarvan ook in android de juiste gegeventypes herkend worden
    mysqli_free_result($result);//maak geheugenresources vrij
    die($return);
}
if ($bewerking == "checkLogin") { //KIJK NA OF LOGIN INFO CORRECT IS
    $result = $conn->query("SELECT GEB_Wachtwoord, GEB_ID FROM tblGebruiker WHERE GEB_Email = '$GEB_Email'"); 
    $return = getJsonObjFromResult($result);// maakt van de inhoud van deze result een json object waarvan ook in android de juiste gegeventypes herkend worden
    mysqli_free_result($result);//maak geheugenresources vrij
    $returnLoginJson = json_decode($return, true); // json versie object
    $wachtwoord = $returnLoginJson["data"][0]["GEB_Wachtwoord"];
    if ($wachtwoord === $GEB_Wachtwoord ) {
        //die($return);//wachtwoord moet niet meegestuurd worden
        $myJsonObj = (object)array("GEB_ID" => $returnLoginJson["data"][0]["GEB_ID"]);
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


if ($bewerking == "addOef") { 
    if ($OEF_Titel &&  
        $OEF_Beschrijving && 
        $OEF_AantalCal &&
        $OEF_Spier &&
        $GEB_ID) {
        // Controle om o.a. SQL injection te voorkomen.
    } else {
        die(addJsonData("400","missing data"));
    }
    $OEF_BeschrijvingBase64 = base64_decode($OEF_Beschrijving);
    if ($conn -> query("insert into tblOefening (OEF_Titel, OEF_Spier, OEF_Beschrijving, OEF_AantalCal, OEF_GEB_ID) values('"
        .$OEF_Titel."','".$OEF_Spier."','".$OEF_BeschrijvingBase64."','".$OEF_AantalCal."','".$GEB_ID."')") === TRUE) { // into $t

    	//CHECK LINK MET GEBRUIKER ID : TOON VOOR WELKE GEBRUIKER DE ROUTINE IS TOEGEVOEGD
        $id = mysqli_insert_id($conn);
        die(addJsonData("200",$id));
    } else {
        die(addJsonData("400","Error adding record: " . $conn -> error));
    }
}

if ($bewerking == "addImageToOef") { //Moet apart gebeuren, anders is het JSON object te groot
    if ($OEF_ID && $OEF_Afbeelding){
        // Controle om o.a. SQL injection te voorkomen.
    } else {
        die(addJsonData("400","missing data"));
    }   
    $decoded = ""; 
    for ($i=0; $i < ceil(strlen($OEF_Afbeelding)/64); $i++) {
        $decoded = $decoded . base64_decode(substr($OEF_Afbeelding,$i*64,64)); 
    }
    if ($conn -> query("UPDATE tblOefening SET OEF_Afbeelding = '$decoded' WHERE OEF_ID = '$OEF_ID'") === TRUE) { // into $t
        $resultGeb = $conn->query("SELECT * FROM tblGebruiker where GEB_ID = $GEB_ID");
        $returnGeb = getJsonObjFromResult($resultGeb);
        mysqli_free_result($resultGeb); // maak geheugenresources vrij
        $returnGebJson = json_decode($returnGeb, true); // json versie object
        $naamGeb = $returnGebJson["data"][0]["GEB_Voornaam"];
    } else {
        die(addJsonData("400","Error adding record: " . $conn -> error));
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
        $id = mysqli_insert_id($conn);
        die(addJsonData("200",$id));
    } else {
        die(addJsonData("400","Error adding record: " . $conn -> error));
    }
}

if ($bewerking == "addRIT") {
    if ($ROU_ID && 
        $OEF_ID){
        // Controle om o.a. SQL injection te voorkomen.
    } else {
        die(addJsonData("400","missing data"));
    }
    if ($conn -> query("insert into tblRoutineItem (RIT_ROU_ID, RIT_OEF_ID) values('"
        .$ROU_ID."','".$OEF_ID."')") === TRUE) { // into $t

    	//CHECK LINK MET GEBRUIKER ID : TOON VOOR WELKE GEBRUIKER DE ROUTINE IS TOEGEVOEGD
        $resultGeb = $conn->query("SELECT * FROM tblGebruiker where GEB_ID = $ROU_GEB_ID");
        $returnGeb = getJsonObjFromResult($resultGeb);
        mysqli_free_result($resultGeb); // maak geheugenresources vrij
        $returnGebJson = json_decode($returnGeb, true); // json versie object
        $naamGeb = $returnGebJson["data"][0]["GEB_Voornaam"];

        die(addJsonData("200","Record added successfully for $naamGeb"));
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
    if ($conn -> query("delete FROM tblRoutine where ROU_ID = $ROU_ID") === TRUE) { // FROM $t
        die(addJsonData("200","Record deleted successfully"));
    } else {
        die(addJsonData("400","Error deleting record: " . $conn -> error));
    }
}

if ($bewerking == "getRouForGeb") { 
    //VRAAGT ROUTINES VOOR EEN GEBRUIKER OP AAN DE HAND VAN GEB_ID
    $result = $conn->query("SELECT ROU_ID, ROU_Naam, ROU_GEB_ID FROM tblRoutine WHERE ROU_GEB_ID = '$GEB_ID'");
    $return = getJsonObjFromResult($result);
    mysqli_free_result($result);
    die($return);
}

if ($bewerking == "getRouForNotGeb") { 
    //VRAAGT ALL ROUTINES MAAR ZONDER JOU ROUTINES OP AAN DE HAND VAN GEB_ID
    $result = $conn->query("SELECT ROU_ID, ROU_Naam, ROU_GEB_ID FROM tblRoutine WHERE ROU_GEB_ID <> '$GEB_ID'");
    $return = getJsonObjFromResult($result);
    mysqli_free_result($result);
    die($return);
}

if ($bewerking == "getOefForGeb") { 
    //VRAAGT ROUTINES VOOR EEN GEBRUIKER OP AAN DE HAND VAN GEB_ID
    $result = $conn->query("SELECT OEF_ID, OEF_Titel, OEF_Spier, OEF_GEB_ID FROM tblOefening WHERE OEF_GEB_ID = '$GEB_ID'");
    $return = getJsonObjFromResult($result);
    mysqli_free_result($result);
    die($return);
}

if ($bewerking == "getOefForNotGeb") { 
    //VRAAGT ROUTINES VOOR EEN GEBRUIKER OP AAN DE HAND VAN GEB_ID
    $result = $conn->query("SELECT OEF_ID, OEF_Titel, OEF_Spier, OEF_GEB_ID FROM tblOefening WHERE OEF_GEB_ID <> '$GEB_ID'");
    $return = getJsonObjFromResult($result);
    mysqli_free_result($result);
    die($return);
}

if ($bewerking == "getOefForRou") { 
    //VRAAGT OEFENINGEN (ID + Titel)  OP VOOR ROUTINE [ROUTINE (NAAM + GEB ID) ZIJN LOKAAL OPGESLAGEN]
    $result = $conn->query("SELECT OEF_ID, OEF_Titel FROM tblRoutineItem INNER JOIN tblOefening ON tblOefening.OEF_ID = tblRoutineItem.RIT_OEF_ID WHERE tblRoutineItem.RIT_ROU_ID = '$ROU_ID'");
    $return = getJsonObjFromResult($result);
    mysqli_free_result($result);
    die($return);
    

}
if ($bewerking == "getKalForGeb") { 
    //VRAAGT ROUTINES, BIJHORENDE OEFENINGEN EN DAG VAN UITVOERING OP AAN DE HAND VAN GEB_ID
    $result = $conn->query("SELECT DISTINCT KIT_ID, ROU_Naam, ROU_ID, ROU_GEB_ID, KIT_DAG FROM tblGebruiker INNER JOIN tblKalenderItem ON tblGebruiker.GEB_ID = tblKalenderItem.KIT_GEB_ID INNER JOIN tblRoutine ON tblKalenderItem.KIT_ROU_ID = tblRoutine.ROU_ID WHERE GEB_ID = '$GEB_ID'");
    $return = getJsonObjFromResult($result);
    mysqli_free_result($result);
    die($return);
}

if ($bewerking == "getKalForGebOnDay") { 
    //VRAAGT ROUTINES, BIJHORENDE OEFENINGEN EN DAG VAN UITVOERING OP AAN DE HAND VAN GEB_ID
    //$result = $conn->query("SELECT DISTINCT ROU_Naam, OEF_Titel, OEF_ID, KIT_DAG FROM tblGebruiker INNER JOIN tblKalenderItem ON tblGebruiker.GEB_ID = tblKalenderItem.KIT_GEB_ID INNER JOIN tblRoutine ON tblKalenderItem.KIT_ROU_ID = tblRoutine.ROU_ID INNER JOIN tblRoutineItem ON tblRoutineItem.RIT_ROU_ID = tblRoutine.ROU_ID INNER JOIN tblOefening ON tblOefening.OEF_ID = tblRoutineItem.RIT_OEF_ID WHERE GEB_ID = '$GEB_ID' AND KIT_DAG = '$KIT_DAG'");
    $result = $conn->query("SELECT DISTINCT ROU_Naam, ROU_ID, ROU_GEB_ID, KIT_DAG FROM tblGebruiker INNER JOIN tblKalenderItem ON tblGebruiker.GEB_ID = tblKalenderItem.KIT_GEB_ID INNER JOIN tblRoutine ON tblKalenderItem.KIT_ROU_ID = tblRoutine.ROU_ID WHERE GEB_ID = '$GEB_ID' AND KIT_DAG = '$KIT_DAG'");
    $return = getJsonObjFromResult($result);
    mysqli_free_result($result);
    die($return);
}

if ($bewerking == "getInfoOef") { 
    //VRAAGT AFBEELDING EN BESCHRIJVINF VAN OEF OP BASIS VAN OEF_ID
    $result = $conn->query("SELECT OEF_Titel, OEF_Afbeelding, OEF_Beschrijving, OEF_AantalCal, OEF_Spier, OEF_Categorie  FROM tblOefening WHERE OEF_ID = '$OEF_ID'");
    $return = getJsonObjFromResult($result);
    mysqli_free_result($result);
    die($return);
}


if ($bewerking == "updateKal") { 
    $check = $conn -> query("SELECT * FROM tblKalenderItem WHERE KIT_ID = '$KIT_ID'");
    if (mysqli_num_rows($check) == 0) {
        if ($conn -> query("INSERT INTO tblKalenderItem (KIT_ROU_ID, KIT_GEB_ID, KIT_DAG) values('".$ROU_ID."','".$GEB_ID."','".$KIT_DAG."')") === TRUE) { // into $t
        //CHECK LINK MET GEBRUIKER ID : TOON VOOR WELKE GEBRUIKER DE ROUTINE IS TOEGEVOEGD
        $resultGeb = $conn->query("SELECT * FROM tblGebruiker where GEB_ID = $GEB_ID");
        $returnGeb = getJsonObjFromResult($resultGeb);
        mysqli_free_result($resultGeb); // maak geheugenresources vrij
        $returnGebJson = json_decode($returnGeb, true); // json versie object
        $naamGeb = $returnGebJson["data"][0]["GEB_Voornaam"];
        die(addJsonData("200","Kalendar updated successfully for $naamGeb"));
    }}else {
        die(addJsonData("400","Error updating kalendar!" . $conn -> error));
    }
}

if ($bewerking == "deleteKit") { 
    if ($conn -> query("DELETE FROM tblKalenderItem WHERE KIT_ID = '$KIT_ID'") === TRUE) { // into $t
        //CHECK LINK MET GEBRUIKER ID : TOON VOOR WELKE GEBRUIKER DE ROUTINE IS TOEGEVOEGD
        $resultGeb = $conn->query("SELECT * FROM tblGebruiker where GEB_ID = $GEB_ID");
        $returnGeb = getJsonObjFromResult($resultGeb);
        mysqli_free_result($resultGeb); // maak geheugenresources vrij
        $returnGebJson = json_decode($returnGeb, true); // json versie object
        $naamGeb = $returnGebJson["data"][0]["GEB_Voornaam"];
        die(addJsonData("200","Kalendar updated successfully for $naamGeb"));
    }else {
        die(addJsonData("400","Error updating kalendar!" . $conn -> error));
    }
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
        MYSQLI_TYPE_DOUBLE,
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
            } else if ($fieldList[$teller]->type == MYSQLI_TYPE_BLOB) { //Zodat texten en afbeeldingen kunnen doorgestuurd worden
                $fixedRow[$key] = base64_encode($value);
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
