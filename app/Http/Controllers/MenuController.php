<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $serverUrl = env('SERVER_URL');
        $apiToken = env('API_TOKEN');
        $data = [
            'isClosed' => '',
            'msg' => '', 
            'opening' => '',
            'closing' => '',
            'code' => '',
            'menus' => []
        ];

        $schedule = is_restaurant_closed();

        if($schedule['isClosed']){
            $data['schedule'] = $schedule;
            $data['isClosed'] = $schedule['isClosed'];
            $data['msg'] = $schedule['message'];
            // $data['opening'] = $schedule['todaySchedule']['opening_time'];
            // $data['closing'] = $schedule['todaySchedule']['closing_time'];
            $data['opening'] = Carbon::createFromFormat('H:i:s', $schedule['todaySchedule']['opening_time'])->format('g:i A');
            $data['closing'] = Carbon::createFromFormat('H:i:s', $schedule['todaySchedule']['closing_time'])->format('g:i A');
        
            $data['code'] = $schedule['code'];
        }
        else{
            $data['isClosed'] = $schedule['isClosed'];
            $response = Http::withHeaders([
                'Authorization' => $apiToken,
            ])->get($serverUrl . 'api/categories');

            if ($response->successful()) {       
                $responseData = $response->json();
                $data['menus'] = $responseData['data'];
            }
        }
        
        return view('pages.menu', $data);
    }

    public function product_detail($id)
    {
        $serverUrl = env('SERVER_URL');
        $apiToken = env('API_TOKEN');

        $apiController = new ApiController();
        $result = $apiController->product($id);

        $categories = Http::withHeaders([
            'Authorization' => $apiToken,
        ])->get($serverUrl . 'api/categories');
        $data['menus'] = $categories['data'];

        $data['response'] = $result['response'];
        $data['product'] = collect($result['products'])->first();

        $data['currencySymbol'] = restaurant_detail()['restaurantDetail']['currency_symbol'];
        
        return view('pages.product_detail', $data);
    }

}
