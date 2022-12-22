<?php

namespace App\Http\Controllers;

use App\Helpers\HttpClient;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {

        $responsePengguna = HttpClient::fetch(
            'GET',
            'http://localhost:8081/api/pengguna/list'
        );

        $pengguna = $responsePengguna["data"];
        
        return view('home', compact('pengguna'));
    }

}
