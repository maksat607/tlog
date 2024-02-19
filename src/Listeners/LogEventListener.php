<?php

namespace Maksatsaparbekov\Tlog\Listeners;

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

            $parseError = $event->context['exception'];

            $message = [
                'project' => env('APP_NAME','Myproject'),
                'message' => $parseError->getMessage(),
                'file' => $parseError->getFile(),
                'line' => $parseError->getLine()
            ];

            ( new TelegramMessageSenderService())->sendMessage(json_encode($message, JSON_UNESCAPED_SLASHES) );

        }
    }
}
