<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class TestPushNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Tunas Muda Abhipraya')
            ->icon('/logo.png') // Sesuaikan path logo jika ada
            ->body('Halo! Ini adalah uji coba kirim Push Notification secara real-time.');
    }
}
