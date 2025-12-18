<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoanStatusUpdated extends Notification
{
    use Queueable;

    public $loan;
    public $status; // 'approved' or 'rejected'
    public $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($loan, $status)
    {
        $this->loan = $loan;
        $this->status = $status;
        
        if ($status === 'approved') {
            $this->message = "Peminjaman {$loan->asset->name} ({$loan->quantity} unit) Anda telah disetujui.";
        } else {
            $this->message = "Peminjaman {$loan->asset->name} Anda ditolak. Alasan: " . ($loan->rejection_reason ?? '-');
        }
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->message,
            'url' => route('warga.loans.index', ['view' => 'history']),
            'loan_id' => $this->loan->id,
            'type' => $this->status === 'approved' ? 'success' : 'danger'
        ];
    }
}
