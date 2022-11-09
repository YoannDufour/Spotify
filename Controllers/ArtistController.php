<?php

namespace App\Controllers;

use App\Entity\Artist;
use App\Entity\Album;
use App\Entity\Track;

class ArtistController extends Controller
{
    public function index()
    {
        $name = 'Orelsan';

        $jsondecode = $this->callAPI("https://api.spotify.com/v1/search?q=$name&type=artist");
        $artists = [];

        foreach ($jsondecode->artists->items as $value) {
            if (!empty($value->images)) {
                $artist = new Artist($value->id, $value->name, $value->followers->total, $value->genres, $value->external_urls->spotify, $value->images[0]->url);
            } else {
                $artist = new Artist($value->id, $value->name, $value->followers->total, $value->genres, $value->external_urls->spotify, "https://returntofreedom.org/store/wp-content/uploads/default-placeholder.png");
            }
            $artists[] = $artist;
        }

        $this->render('artist/index', compact('artists'));
    }

    public function callAPI($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $_SESSION['token']));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result);
    }
}