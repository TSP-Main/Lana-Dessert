<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;


function is_restaurant_closed()
{
    $serverUrl = env('SERVER_URL');
    $apiToken = env('API_TOKEN');

    $scheduleData = Http::withHeaders([
        'Authorization' => $apiToken,
    ])->get($serverUrl . 'api/schedule');

    $scheduleData = $sresponseData['data']['schedule'];
    $timezone = $sresponseData['data']['timezone'][0];

    
    $today = Carbon::now($timezone)->format('l');
    $todaySchedule = collect($scheduleData)->firstWhere('day', $today);


    if ($todaySchedule['is_closed'] || !$todaySchedule['opening_time'] || !$todaySchedule['closing_time']) {
        $data['isClosed'] = true;
        $data['message'] = 'Restaurant Is Closed Today';
        $data['code'] = '001';
    }
    else{
        $currentTime = Carbon::now();

        $openingTime = Carbon::createFromFormat('H:i:s', $todaySchedule['opening_time']);
        $closingTime = Carbon::createFromFormat('H:i:s', $todaySchedule['closing_time']);

        if ($currentTime->between($openingTime, $closingTime)) {
            $data['isClosed'] = false;
        }
        else{
            $data['isClosed'] = true;
            $data['message'] = 'Restaurant Timing is this';
            $data['code'] = '002';
        }
    }
    $data['todaySchedule'] = $todaySchedule;

    return $data;
}