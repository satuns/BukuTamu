<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class Mahasiswa extends Controller
{
    public function getMahasiswa($nim)
    {

        // $client = new Client();

        // $response = $client->request(
        //     'GET',
        //     "https://api-frontend.kemdikbud.go.id/hit_mhs/{$nim}",
        //     [
        //         "headers" => [
        //             "Host" => "api-frontend.kemdikbud.go.id",
        //             "Upgrade-Insecure-Requests" => 1,
        //             "User-Agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36"
        //         ]
        //     ]
        // );

        $response = Http::get("https://api-frontend.kemdikbud.go.id/hit_mhs/$nim");
        dd($response);
        return response()->json($response->getBody());
    }
}
