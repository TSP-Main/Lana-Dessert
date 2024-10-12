<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        $serverUrl = env('SERVER_URL');
        $apiToken = env('API_TOKEN');
        
        $response = Http::withHeaders([
            'Authorization' => $apiToken,
        ])->get($serverUrl . 'api/categories_a');

        if ($response->successful()) {
            $data['response'] = true;
            $data['categories'] = collect($response->json('data')); // Convert to Collection
        } else {
            $data['response'] = false;
            $data['categories'] = collect(); // Ensure $categories is always a Collection
        }
        
        return view('dashboard', $data);
    }

    public function error_404()
    {
        return view('404');
    }
}
