<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLetterRequest extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $letter;

    public function __construct($letter)
    {
        $this->letter = $letter;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Permohonan surat baru: ' . $this->letter->letterType->name . ' dari ' . $this->letter->user->name,
            'url' => route('operator.letters.index'), // Link to index page
            'letter_id' => $this->letter->id,
            'type' => 'info'
        ];
    }
}
