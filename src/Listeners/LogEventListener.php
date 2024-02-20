<?php

namespace Maksatsaparbekov\Tlog\Listeners;

use Illuminate\Support\Facades\Log;
use Maksatsaparbekov\Tlog\Services\TelegramMessageSenderService;

class LogEventListener
{
    public $user = null;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        if ($event->level == 'error') {
            $message = [
                'project' => env('APP_NAME', 'Myproject'),
                'message' => isset($event->context['exception']) ? $event->context['exception']->getMessage() : $event->message,
                'file' => isset($event->context['exception']) ? $event->context['exception']->getFile() : null,
                'line' => isset($event->context['exception']) ? $event->context['exception']->getLine() : null
            ];

            // Additional checks or modifications to $message can be done here

            (new TelegramMessageSenderService())->sendMessage($message);
        }
    }


}
