<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminOrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Order data
     */
    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orderData)
    {
        $this->order = $orderData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Đơn hàng mới #' . $this->order['order_id'])
                    ->markdown('emails.admin-order-notification');
    }
}
