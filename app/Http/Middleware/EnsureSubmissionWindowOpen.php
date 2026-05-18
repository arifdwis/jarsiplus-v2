<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSubmissionWindowOpen
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $now = now();
        
        $openDate = \App\Domain\Integration\Models\AppSetting::where('key', 'submission_open_date')
            ->value('value');
        $closeDate = \App\Domain\Integration\Models\AppSetting::where('key', 'submission_close_date')
            ->value('value');

        if (!$openDate || !$closeDate) {
            return response()->json(['error' => 'Submission window not configured'], 500);
        }

        $openDate = \Carbon\Carbon::parse($openDate);
        $closeDate = \Carbon\Carbon::parse($closeDate);

        if ($now->isBefore($openDate) || $now->isAfter($closeDate)) {
            return response()->json([
                'error' => 'Submission window is closed',
                'open_date' => $openDate->format('Y-m-d H:i:s'),
                'close_date' => $closeDate->format('Y-m-d H:i:s'),
            ], 403);
        }

        return $next($request);
    }
}
