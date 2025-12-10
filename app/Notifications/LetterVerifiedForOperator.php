<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LetterVerifiedForOperator extends Notification
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
            'message' => 'Surat ' . $this->letter->letterType->name . ' an. ' . $this->letter->user->name . ' telah diverifikasi oleh Kepala Desa.',
            'url' => route('operator.letters.index'),
            'type' => 'success'
        ];
    }
}
