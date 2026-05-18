<?php

namespace App\Domain\Integration\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MonografiService
{
    protected string $apiUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->apiUrl = config('services.monografi.url');
        $this->apiKey = config('services.monografi.key');
    }

    /**
     * Get monografi data for a city
     */
    public function getMonografi(int $cityId): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
            ])->get("{$this->apiUrl}/monografi/{$cityId}");

            if ($response->successful()) {
                return $response->json('data', []);
            }

            Log::error("Monografi fetch failed: {$response->body()}");
            return [];
        } catch (\Exception $e) {
            Log::error("Monografi service exception: {$e->getMessage()}");
            return [];
        }
    }

    /**
     * Submit monografi data
     */
    public function submitMonografi(int $cityId, array $data): bool
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type' => 'application/json',
            ])->post("{$this->apiUrl}/submit", array_merge(['city_id' => $cityId], $data));

            if ($response->successful()) {
                Log::info("Monografi submitted for city {$cityId}");
                return true;
            }

            Log::error("Monografi submission failed: {$response->body()}");
            return false;
        } catch (\Exception $e) {
            Log::error("Monografi submission exception: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Get monografi statistics
     */
    public function getStatistics(int $cityId): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
            ])->get("{$this->apiUrl}/statistics/{$cityId}");

            if ($response->successful()) {
                return $response->json('data', []);
            }

            Log::error("Monografi statistics fetch failed: {$response->body()}");
            return [];
        } catch (\Exception $e) {
            Log::error("Monografi statistics exception: {$e->getMessage()}");
            return [];
        }
    }
}
