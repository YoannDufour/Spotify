<?php

namespace App\Core;

class AuthSpotify
{
    public function auth(): void
    {
        $newTokenNeeded = false;
        if (empty($_SESSION)) {
            $newTokenNeeded = true;
        } else {
            if ($_SESSION['expire'] <= time()) {
                $newTokenNeeded = true;
            }
        }

        if ($newTokenNeeded) {

            $clientId = "4e9680be6abe456d841ca0ef28bf7f78";
            $clientSecret = "f854f8976c164c5daff7956b122c1bf5";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://accounts.spotify.com/api/token');
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Basic ' . base64_encode($clientId . ':' . $clientSecret)
            ]);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                'grant_type' => 'client_credentials'
            ]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = json_decode(curl_exec($ch), true);
            curl_close($ch);


            $_SESSION['token'] = $result['access_token'];
            $_SESSION['expire'] = time() + 3600;
        }
    }
}