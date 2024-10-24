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
            $data['categories'] = collect($response->json('data'));
        } else {
            $data['response'] = false;
            $data['categories'] = collect();
        }

        // fetch total products
        $data['totalProducts'] = 0;
        $url = 'api/products';

        $products = Http::withHeaders([
            'Authorization' => $apiToken,
        ])->get($serverUrl . $url);

        if($products['status'] == 'success'){
            $data['totalProducts'] = $products['data'] ? count($products['data']) : 0;
        }

        // fetch total customers
        $data['totalCustomers'] = 0;
        $url = 'api/customers';

        $customers = Http::withHeaders([
            'Authorization' => $apiToken,
        ])->get($serverUrl . $url);

        if($customers['status'] == 'success'){
            $data['totalCustomers'] = $customers['data'] ? $customers['data'] : 0;
        }
        
        return view('dashboard', $data);
    }

    public function error_404()
    {
        return view('404');
    }
}
