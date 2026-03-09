<?php

namespace App\Notifications;

use App\Models\Investment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvestmentCreatedNotification extends Notification
{
    use Queueable;

    protected $investment;

    public function __construct(Investment $investment)
    {
        $this->investment = $investment;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Investment Has Been Created')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('We are excited to inform you that your investment has been successfully created.')
            ->line('Here are the details of your investment:')
            ->line('💰 Capital: ' . number_format($this->investment->capital, 2))
            ->line('📈 Expected Return: ' . number_format($this->investment->return, 2))
            ->line('🗓 Start Date: ' . $this->investment->created_at->format('d M, Y'))
            ->line('🗓 End Date: ' . $this->investment->end_date->format('d M, Y'))
            ->line('💡 Investment Type: ' . $this->investment->type)
            ->action('View Investment', url('/investments/' . $this->investment->id))
            ->line('Thank you for investing with us!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Your investment has been successfully created.',
            'investment_id' => $this->investment->id,
            'capital' => $this->investment->capital,
            'return' => $this->investment->return,
            'start_date' => $this->investment->start_date,
            'end_date' => $this->investment->end_date,
            'type' => $this->investment->type,
        ];
    }
}
