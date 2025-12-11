<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LetterVerified extends Notification
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
            'message' => 'Surat ' . $this->letter->letterType->name . ' Anda telah diterbitkan. Silakan unduh.',
            'url' => route('warga.letters.index', ['view' => 'history']),
            'letter_id' => $this->letter->id,
            'type' => 'success'
        ];
    }
}
