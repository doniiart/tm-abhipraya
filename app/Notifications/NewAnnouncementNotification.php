<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;
use Illuminate\Support\Str;

class NewAnnouncementNotification extends Notification
{
    use Queueable;

    protected $pengumuman;

    // Menerima data pengumuman yang dikirim dari controller
    public function __construct($pengumuman)
    {
        $this->pengumuman = $pengumuman;
    }

    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title($this->pengumuman->judul ?? 'Pengumuman Karang Taruna')
            ->icon('/logo.png')
            ->body(Str::limit($this->pengumuman->isi ?? $this->pengumuman->konten ?? 'Ada informasi penting baru untuk Pemuda Abhipraya.', 100))
            ->action('Buka Website', url('/pengumuman')); // Tombol aksi di notifikasi
    }
}
