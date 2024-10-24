<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AboutController extends Controller

{
    public function index()
    {
        $serverUrl = env('SERVER_URL');
        $apiToken = env('API_TOKEN');
        
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

        return view ('pages.about', $data);
    }
    
}
