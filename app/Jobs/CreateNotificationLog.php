<?php

namespace App\Jobs;

use App\Domain\Integration\Models\NotificationLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateNotificationLog implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected int $userId,
        protected string $type,
        protected string $title,
        protected string $message,
        protected ?array $data = null,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        NotificationLog::create([
            'user_id' => $this->userId,
            'type' => $this->type,
            'title' => $this->title,
            'message' => $this->message,
            'data' => $this->data,
        ]);
    }
}
