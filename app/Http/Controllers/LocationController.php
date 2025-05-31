<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\LocationIQService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    protected $locationIQ;

    public function __construct(LocationIQService $locationIQ)
    {
        $this->locationIQ = $locationIQ;
    }

    /**
     * Geocode an address using LocationIQ.
     *
     * @param Request $request
     * @param string|null $address
     * @return JsonResponse
     */
    public function geocode(Request $request, string $address = null): JsonResponse
    {
        try {
            Log::info('Geocode request received');
            
            $address = $address
                ?? $request->query('address')
                ?? $request->input('address');

            if (empty($address)) {
                Log::warning('No address provided');
                return response()->json([
                    'error' => 'Address is required'
                ], 400);
            }

            Log::info('Processing address: ' . $address);
            $result = $this->locationIQ->geocode($address);

            if (isset($result['error'])) {
                Log::error('Geocoding error: ' . $result['error']);
                return response()->json($result, $result['status'] ?? 500);
            }

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Geocoding exception: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while geocoding the address: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get the weather for a given latitude and longitude.
     *
     * @param float $lat
     * @param float $lon
     * @return array
     */
    public function getWeather($lat, $lon)
    {
        $apiKey = config('services.weatherapi.key');
        $url = 'http://api.weatherapi.com/v1/current.json';
        $response = Http::get($url, [
            'key' => $apiKey,
            'q' => "{$lat},{$lon}",
        ]);
        return $response->json();
    }
}
