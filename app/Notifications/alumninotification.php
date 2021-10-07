<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class alumninotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->status = $status;
        $this->id_alumni = $id_alumni;
        $this->id_notifikasi = $id_notifikasi;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $status = $this->$status;
        $id_alumni = $this->$id_alumni;
        $id_notifikasi = $this->id_notifikasi;
        $pesan = '';
        
        if($status == "Ditolak"){ 
            $pesan = "Registrasi Data diri "."$nama_alumni"."Ditolak";
        }elseif($status == "Konfirmasi"){
            $pesan = "Registrasi Data "."$nama_alumni"."Diterima";
        }

        $data = ['pesan'=>$pesan, 'id_alumni'=>$id_alumni,"id_notifikasi"=>$id_notifikasi,"nama_alumni"=>$nama_alumni];

        return $data;
    }
}
