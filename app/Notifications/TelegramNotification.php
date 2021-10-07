<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use TelegramNotifications\TelegramChannel;
use TelegramNotifications\Messages\TelegramMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TelegramNotification extends Notification
{
    use Queueable;

    public function __construct(array $arr)
    {
        $this->data = $arr;
    }

    // public function via($notifiable)
    // {
    //     return ['mail'];
    // }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    // public function toTelegram() {
    //     return (new TelegramMessage())
    //         ->text($this->data['text']);
    // }

    public function toArray($notifiable)
    {
        return [
            
        ];
    }

    public function toTelegram() {
        return (new TelegramCollection())
            ->message(['judul' => $this->data['judul']])
            ->location(['jenis' => $this->data['jenis'], 'longitude' => $this->data['longitude']])
            ->photo(['photo' => $this->data['photo'], 'caption' => $this->data['photo_caption']]);
    }
}
