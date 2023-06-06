<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class GeocodeController extends Controller
{
    public function geocode(Request $request){
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        
        $url = "https://maps.google.com/maps/api/geocode/json?latlng=$latitude,$longitude";
        
        $client = new Client();
        $response = $client->get($url);
        
        return $response->getBody();
    }
}
