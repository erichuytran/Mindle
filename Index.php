<?php
session_start() ;


if ( empty($_SESSION["Access_Token"]) or empty($_SESSION['Refresh_Token'])) {


    $codelog = $_GET['code'];

//Sauvegarde des donnee compte spotify developer (Crée un compte commun pour MINDLE)
    $clientID = "d7e7b3c0c51346168fcc2b3fac5dfe96";
    $ClientSecret = "6b919c3ebba14aa3b4aea5cb5813190f";
    $base64 = base64_decode("$clientID : $ClientSecret");
    $Authorization = "Authorization: Basic $base64";
    $idUser = "";

    // Requetepour recuperer le token d'autorisation spotify (validée par l'utilisateur)
    $code = $_GET['code'];
    $token_url = "https://accounts.spotify.com/api/token";
    $header = array('Authorization: Basic ' . base64_encode($clientID . ':' . $ClientSecret), "Content-Type: application/x-www-form-urlencoded");
    $content = "grant_type=authorization_code&code=$codelog&redirect_uri=http://Mindle/Index.php";


    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $token_url,
        CURLOPT_HTTPHEADER => $header,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $content
    ));
echo "2";
    $response = curl_exec($curl);
    $Responsejson = json_decode($response);
    $access_token = $Responsejson->access_token;
    $refresh_token = $Responsejson->refresh_token;

    echo $response; //affiche la representation des données du token (peut etre utile pour les autres requetes)

    if ($access_token != "" or $refresh_token != "") {
        $_SESSION["Access_Token"] = $access_token;
        $_SESSION['Refresh_Token'] = $refresh_token;

    }
}


//Requete pour récuperer les infos de l'utilisateur
$token_url2 = "https://api.spotify.com/v1/me";
$header = array('Authorization: Bearer ' .$_SESSION["Access_Token"] ,'Accept: application/json', "Content-Type: application/json");



$curl2 = curl_init();
curl_setopt_array($curl2, array(
    CURLOPT_URL => $token_url2,
    CURLOPT_HTTPHEADER => $header,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_RETURNTRANSFER => true,

));

// recuperation de l'image de l'utilisateur
$imageP = null;
$response2 = curl_exec($curl2);
$Responsejson2 = json_decode($response2);
$images = $Responsejson2->images;
$image = $images[0];

//parcours les donneés corespondant a l'image (A amélioré)
foreach ($image as $value){
    if ($value != null){
    $imageP = $value;
    }
}



//requete pour récuperer les playliste de l'utilisateur
$token_url3 = "https://api.spotify.com/v1/me/playlists";
$header = array('Authorization: Bearer ' .$_SESSION["Access_Token"] ,'Accept: application/json', "Content-Type: application/json");



$curl3 = curl_init();
curl_setopt_array($curl3, array(
    CURLOPT_URL => $token_url3,
    CURLOPT_HTTPHEADER => $header,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_RETURNTRANSFER => true,

));

// decomposition des données playlist a revoir
$response3 = curl_exec($curl3);
$Responsejson3 = json_decode($response3);
//var_dump($Responsejson3);   -> permet de voir les donnée récuperer
$playlists = $Responsejson3->items;
//var_dump($playlists);
foreach($playlists as $valeur){
 //           echo $valeur;
        }

?>


<h1>  TEST CONNECTION  </h1>
<img src="<?php echo $imageP ?>">
<h2 href="<?php echo $imageP ?>"> test</h2>


<h2>SESSION access token : <?php echo $_SESSION["Access_Token"] ?></h2>
<h2>SESSSION refresh token : <?php echo $_SESSION['Refresh_Token'] ?></h2>
