<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class MeetingReminder extends Notification
{
    use Queueable;

    public $meetingData;

    // Saat notifikasi dibuat, kita minta data jadwal kumpulan
    public function __construct($meetingData)
    {
        $this->meetingData = $meetingData;
    }

    // Menentukan bahwa notifikasi ini dikirim via Web Push
    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    // Format isi pesan yang akan tampil di HP
    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Pengingat Kumpulan Karang Taruna')
            ->icon('/logo.png')
            ->body('Malam Minggu Pon ini ada kumpulan di rumah ' . $this->meetingData['host_name'] . '. Jangan lupa hadir ya!')
            ->action('Lihat Detail', 'view_agenda')
            ->data(['action_url' => url('/kumpulan/' . $this->meetingData['id'])]);
    }
}