<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserData extends Controller {

    public function index() {
        $client = new \GuzzleHttp\Client();
        $response = $client->get('http://127.0.0.1:9002/api/auth/userList');
        $userDataLists = json_decode($response->getBody());
        $userDataList = $userDataLists->data;
        return view('userlistone', compact('userDataList'));
    }

    public function indexk() {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://127.0.0.1:9002/api/auth/userList",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $user = json_decode($response);
        $userDataList = (array) $user->data;
        return view('userlist', compact('userDataList'));
    }

}
