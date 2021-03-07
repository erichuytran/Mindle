<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class ConnexionAction extends UserAction
{
/**
     * {@inheritdoc}
     */


    // Récupération d'un titre aléatoire, via une recherche avec des paramètres aléatoires
    protected function getRandomSong($auth) :Response{         
            
        // Liste des caractères pouvant être choisis aléatoirement pour la recherche
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        // Récupération d’un caractère aléatoire 
        $randomNb = intVal(floor((rand( 0,strlen($characters)))) );
        $randomCharacter = substr($characters,  $randomNb  , 1);
        $randomSearch = '';
        // On place le caractère choisis au début, ou à l’intérieur de la recherche, aléatoirement
        switch (round(rand(0,1))) {
            case 0:
            $randomSearch = $randomCharacter . '%25';
            break;
            case 1:
            $randomSearch = '%25' . $randomCharacter . '%25';
            break;
        }

           //On récupère un index aléatoire
           $randomOffset = floor(rand(0, 100));


           //Requete pour récuperer un chanson aléatoire via une recherche
               $token_url_search = "https://api.spotify.com/v1/search?q=".$randomSearch."&type=track&limit=1&offset=".$randomOffset;
               $header_search = array('Authorization: Bearer ' .$auth ,'Accept: application/json', "Content-Type: application/json");

               $curl_search = curl_init();
               curl_setopt_array($curl_search, array(
               CURLOPT_URL => $token_url_search,
               CURLOPT_HTTPHEADER => $header_search,
               CURLOPT_SSL_VERIFYPEER => false,
               CURLOPT_RETURNTRANSFER => true,
               ));

               $response_search = curl_exec($curl_search);
               $Responsejson_search = json_decode($response_search);
               $track = $Responsejson_search->tracks->items;
  
               return $this->respondWithData($track); 

    }


    // Fonction initié lors de l'appelle à la classe ConnexionAction
    // Elle attends un retour type Response
    protected function action(): Response
    {

            session_start() ;


        if ( empty($_SESSION["Access_Token"]) or empty($_SESSION['Refresh_Token'])) {

            $codelog = $_GET['code'];

            //Sauvegarde des donnees du compte spotify developers
            $clientID = "8e43f58a8786457dba7f442dcaa1e017";
            $ClientSecret = "574002c8ac934a889928da34be1a2e22";
            $base64 = base64_decode("$clientID : $ClientSecret");
            $Authorization = "Authorization: Basic $base64";
            $idUser = "";

            // Requete pour recuperer le token d'autorisation spotify 
            $token_url = "https://accounts.spotify.com/api/token";
            $header = array('Authorization: Basic ' . base64_encode($clientID . ':' . $ClientSecret), "Content-Type: application/x-www-form-urlencoded");
            $content = "grant_type=authorization_code&code=$codelog&redirect_uri=http://localhost:8080/";


            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $token_url,
                CURLOPT_HTTPHEADER => $header,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $content
            ));
            $response = curl_exec($curl);
            $Responsejson = json_decode($response);
            $access_token = $Responsejson->access_token;
            $refresh_token = $Responsejson->refresh_token;

            //Affiche la representation des données du token (peut etre utile pour les autres requetes)
            if ($access_token != "" or $refresh_token != "") {
                $_SESSION["Access_Token"] = $access_token;
                $_SESSION['Refresh_Token'] = $refresh_token;

            }

            $resultSong = $this->getRandomSong($_SESSION["Access_Token"]);

            return  $resultSong; 


            }
            else{

                $resultSong = $this->getRandomSong($_SESSION["Access_Token"]);

                return  $resultSong; 

            }
        }

    
}
