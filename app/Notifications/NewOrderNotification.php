<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewOrderNotification extends Notification
{
    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
         return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'طلب جديد 🔥',
            'message' => 'لديك طلب جديد رقم #' . $this->order->id,
            'order_id' => $this->order->id
        ];
    }

    public function toBroadcast($notifiable)
{
    return new BroadcastMessage([
        'title' => 'طلب جديد 🔥',
        'message' => 'لديك طلب جديد رقم #' . $this->order->id,
        'order_id' => $this->order->id
    ]);
}
public function broadcastOn()
{
    return ['private-user-' . $this->order->restaurant->user_id];
}
public function broadcastAs()
{
    return 'new.order';
}
public function toArray($notifiable)
{
    return [
        'order_id' => $this->order->id,
    ];
}
}