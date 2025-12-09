<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLoanRequest extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $loan;

    public function __construct($loan)
    {
        $this->loan = $loan;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Peminjaman baru: ' . $this->loan->asset->name . ' (' . $this->loan->quantity . ' unit) dari ' . $this->loan->user->name,
            'url' => route('operator.loans.index'),
            'type' => 'info'
        ];
    }
}
