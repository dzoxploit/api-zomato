<?php
// app/Http/Controllers/RestaurantController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class RestaurantController extends ApiBaseController
{
    public function searchRestaurants(Request $request)
    {

        try {
        // Fetch data from the Zomato API
        $validator = Validator::make($request->all(), [
                        'query' => 'required|string|min:3',
                    ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input', 'errors' => $validator->errors()], 400);
        }

        $apiKey = 'your_zomato_api_key';
        $query = $request->get('query');

        $response = Http::get("https://developers.zomato.com/api/v2.1/search?q=$query", [
            'user-key' => $apiKey,
        ]);

        $restaurants = $response->json()['restaurants'];
        $perPage = 10; // Number of restaurants per page

        $currentPage = Paginator::resolveCurrentPage() ?? 1;
        $paginatedData = array_slice($restaurants, ($currentPage - 1) * $perPage, $perPage);
        $paginatedRestaurants = new Paginator($paginatedData, count($restaurants), $perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath(),
        ]);

        Cache::put($cacheKey, $restaurants, now()->addHour());

        // Log successful API requests
        Log::channel('api')->info('API Request', [
            'url' => $request->url(),
            'method' => $request->method(),
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ]);

        return response()->json($paginatedRestaurants, 200);
    } catch (\Exception $e) {
        // Log API errors
        Log::channel('api')->error('API Error', [
            'url' => $request->url(),
            'method' => $request->method(),
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'error_message' => $e->getMessage(),
        ]);

        return response()->json(['error' => 'Internal Server Error'], 500);
    }

    }
}
