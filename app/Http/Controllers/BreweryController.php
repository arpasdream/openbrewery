<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BreweryController extends Controller
{
    public function listBreweries(Request $request)
    {
        $page = $request->query('page', 1);
        $response = Http::get("https://api.openbrewerydb.org/breweries", [
            'page' => $page,
            'per_page' => 10,
        ]);

        return response()->json($response->json());
    }
}
