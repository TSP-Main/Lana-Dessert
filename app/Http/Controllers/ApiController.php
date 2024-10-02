<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function categories()
    {
        $serverUrl = env('SERVER_URL');
        $apiToken = env('API_TOKEN');
        
        
        $response = Http::withHeaders([
            'Authorization' => $apiToken,
        ])->get($serverUrl . 'api/categories_a');

        if($response['status'] == 'success'){
            $data['response'] = true;
            $data['categories'] = $response['data'];
        }
        else{
            $data['response'] = false;
        }
        
        return view('dashboard', $data);

    }

    public function products(Request $request)
    {
        $serverUrl = env('SERVER_URL');
        $apiToken = env('API_TOKEN');

        $schedule = is_restaurant_closed();

        if($schedule['isClosed']){
            $data['schedule'] = $schedule;
            $data['isClosed'] = $schedule['isClosed'];

            return redirect()->route('menus');
        }
        else{
            $url = 'api/category/products/' . $request->category;
        
            $response = Http::withHeaders([
                'Authorization' => $apiToken,
            ])->get($serverUrl . $url);

            $categories = Http::withHeaders([
                'Authorization' => $apiToken,
            ])->get($serverUrl . 'api/categories');
            $data['menus'] = $categories['data'];

            if($response['status'] == 'success'){
                $data['response'] = true;
                $data['products'] = $response['data'];
                $data['category'] = $request->category;
                $data['categoryDetail'] = $response['categoryDetail'];
            }
            else{
                $data['response'] = false;
                // $data['category'] = $request->category;
            }
        }

        $data['currencySymbol'] = restaurant_detail()['restaurantDetail']['currency_symbol'];
        return view('pages.products', $data);
    }

    public function product($id)
    {
        $serverUrl = env('SERVER_URL');
        $apiToken = env('API_TOKEN');

        $url = 'api/products/' . $id;
        
        $response = Http::withHeaders([
            'Authorization' => $apiToken,
        ])->get($serverUrl . $url);

        if($response['status'] == 'success'){
            $data['response'] = true;
            $data['products'] = $response['data'];
        }
        else{
            $data['response'] = false;
        }

        return $data;
    }

    public function options_detail($ids)
    {
        $serverUrl = env('SERVER_URL');
        $apiToken = env('API_TOKEN');

        $url = 'api/options/detail/';

        $response = Http::withHeaders([
            'Authorization' => $apiToken,
        ])->get($serverUrl . $url, $ids);

        if($response['status'] == 'success'){
            $data['response'] = true;
            $data['options'] = $response['data'];
        }
        else{
            $data['response'] = false;
        }

        return $data;
    }

    public function newsletter_subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $postData['email'] = $request->email;

        $serverUrl  = env('SERVER_URL');
        $apiToken   = env('API_TOKEN');
        $url        = 'api/newsletter/subscribe';
    
        // Make the API request
        $response = Http::withHeaders([
            'Authorization' => $apiToken,
        ])->post($serverUrl . $url, $postData);
        
        if($response['status'] == 'success'){
            return response()->json(['status' => 'success']);
        }
        else{
            return response()->json(['status' => 'error']);
        }
    }

    public function discount_check(Request $request)
    {
        $request->validate([
            'code' => 'required|alpha_num',
        ]);

        $postData['code'] = $request->code;

        $serverUrl  = env('SERVER_URL');
        $apiToken   = env('API_TOKEN');
        $url        = 'api/discount/check';
    
        // Make the API request
        $response = Http::withHeaders([
            'Authorization' => $apiToken,
        ])->post($serverUrl . $url, $postData);

        if($response['status'] == 'success'){
            $data['status'] = true;
            $data['discountDetail'] = $response['data'];
        }
        else{
            $data['status'] = false;
            $data['message'] = $response['message'];
        }

        return $data;
    }
    
}
