<?php

namespace App\Mail\Pickup;

use App\Models\Pickup;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Pickup $pickup;
    public string $messageContent;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Pickup $pickup, string $messageContent = '')
    {
        $this->pickup = $pickup;
        $this->messageContent = $messageContent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(__('Pickup Notification - :code', ['code' => $this->pickup->code]))
            ->view('email.pickup.send-notification');
    }
}
