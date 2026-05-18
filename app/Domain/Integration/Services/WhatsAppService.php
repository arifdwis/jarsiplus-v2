<?php

namespace App\Domain\Integration\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected string $apiUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->apiUrl = config('services.whatsapp.url');
        $this->apiKey = config('services.whatsapp.key');
    }

    /**
     * Send WhatsApp message to a phone number
     */
    public function send(string $phoneNumber, string $message): bool
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type' => 'application/json',
            ])->post("{$this->apiUrl}/send", [
                'phone' => $phoneNumber,
                'message' => $message,
            ]);

            if ($response->successful()) {
                Log::info("WhatsApp message sent to {$phoneNumber}");
                return true;
            }

            Log::error("WhatsApp send failed: {$response->body()}");
            return false;
        } catch (\Exception $e) {
            Log::error("WhatsApp service error: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Send notification about permohonan status change
     */
    public function notifyPermohonanStatusChange(string $phoneNumber, string $permohonanTitle, string $newStatus): bool
    {
        $message = "Permohonan '{$permohonanTitle}' status berubah menjadi: {$newStatus}";
        return $this->send($phoneNumber, $message);
    }

    /**
     * Send approval notification
     */
    public function notifyApproval(string $phoneNumber, string $permohonanTitle, string $approvalStatus): bool
    {
        $message = "Permohonan '{$permohonanTitle}' telah di-{$approvalStatus}";
        return $this->send($phoneNumber, $message);
    }
}
