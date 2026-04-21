<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public string $statusLabel;
    public string $statusMessage;

    public function __construct(Order $order)
    {
        $this->order = $order;

        $map = [
            Order::STATUS_CONFIRMED  => ['Đã xác nhận',      'Đơn hàng của bạn đã được xác nhận và đang chuẩn bị xuất kho.'],
            Order::STATUS_SHIPPING   => ['Đang vận chuyển',  'Đơn hàng đã được bàn giao cho đơn vị vận chuyển.'],
            Order::STATUS_COMPLETED  => ['Giao thành công',  'Đơn hàng đã được giao thành công. Cảm ơn bạn đã mua hàng tại BoPC!'],
        ];

        $this->statusLabel   = $map[$order->status][0] ?? 'Cập nhật đơn hàng';
        $this->statusMessage = $map[$order->status][1] ?? 'Trạng thái đơn hàng của bạn đã được cập nhật.';
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[BoPC] Đơn hàng #' . $this->order->id . ' — ' . $this->statusLabel,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-status',
        );
    }
}
