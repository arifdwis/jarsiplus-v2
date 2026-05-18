<?php

namespace App\Domain\Integration\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class JuriService
{
    protected string $apiUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->apiUrl = config('services.juri.url');
        $this->apiKey = config('services.juri.key');
    }

    /**
     * Get list of juri (evaluators)
     */
    public function getJuriList(): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
            ])->get("{$this->apiUrl}/juri");

            if ($response->successful()) {
                return $response->json('data', []);
            }

            Log::error("Juri service error: {$response->body()}");
            return [];
        } catch (\Exception $e) {
            Log::error("Juri service exception: {$e->getMessage()}");
            return [];
        }
    }

    /**
     * Assign juri to permohonan
     */
    public function assignJuri(int $permohonanId, array $juriIds): bool
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type' => 'application/json',
            ])->post("{$this->apiUrl}/assign", [
                'permohonan_id' => $permohonanId,
                'juri_ids' => $juriIds,
            ]);

            if ($response->successful()) {
                Log::info("Juri assigned to permohonan {$permohonanId}");
                return true;
            }

            Log::error("Juri assignment failed: {$response->body()}");
            return false;
        } catch (\Exception $e) {
            Log::error("Juri assignment exception: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Get juri scoring for permohonan
     */
    public function getScoring(int $permohonanId): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
            ])->get("{$this->apiUrl}/scoring/{$permohonanId}");

            if ($response->successful()) {
                return $response->json('data', []);
            }

            Log::error("Juri scoring fetch failed: {$response->body()}");
            return [];
        } catch (\Exception $e) {
            Log::error("Juri scoring exception: {$e->getMessage()}");
            return [];
        }
    }
}
