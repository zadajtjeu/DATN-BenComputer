<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;
use App\Enums\OrderStatus;
use Illuminate\Notifications\Messages\MailMessage;

class OrderStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;

    protected $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;

        $orderStatusMessage = [
            OrderStatus::NEW_ORDER => 'recently added',
            OrderStatus::IN_PROCCESS => 'has been approved',
            OrderStatus::IN_SHIPPING => 'in transit',
            OrderStatus::COMPLETED => 'is completed',
            OrderStatus::CANCELED => 'is canceled',
        ];

        $this->message =  __(
            'Order #:code ' . $orderStatusMessage[$order->status],
            ['code' => $order->order_code]
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->order->user->email)
            ->subject('[' . env('APP_NAME') . '] ' . __('Order Status Update'))
            ->view('emails.orderupdate', [
                'order' => $this->order,
            ]);
    }
}
