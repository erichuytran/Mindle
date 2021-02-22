<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class ListUsersAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
      /*  $users = $this->userRepository->findAll();

        $this->logger->info("Users list was viewed.");

        return $this->respondWithData($users);*/

        

            session_start() ;


            if ( empty($_SESSION["Access_Token"]) or empty($_SESSION['Refresh_Token'])) {


                $codelog = $_GET['code'];

            //Sauvegarde des donnee compte spotify developer (Crée un compte commun pour MINDLE)
                $clientID = "43ac2cfe3b854357b97fcc1269ac7968";
                $ClientSecret = "5644dea5ec874e4386b71dd0f77fc613";
                $base64 = base64_decode("$clientID : $ClientSecret");
                $Authorization = "Authorization: Basic $base64";
                $idUser = "";

                // Requetepour recuperer le token d'autorisation spotify (validée par l'utilisateur)
               // $code = $_GET['code'];
                $token_url = "https://accounts.spotify.com/api/token";
                $header = array('Authorization: Basic ' . base64_encode($clientID . ':' . $ClientSecret), "Content-Type: application/x-www-form-urlencoded");
                $content = "grant_type=authorization_code&code=$codelog&redirect_uri=http://localhost:8080/users";


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

               // echo $response; //affiche la representation des données du token (peut etre utile pour les autres requetes)
                if ($access_token != "" or $refresh_token != "") {
                    $_SESSION["Access_Token"] = $access_token;
                    $_SESSION['Refresh_Token'] = $refresh_token;

                }

                return $this->respondWithData($access_token) ;

            }
    
    }
}
