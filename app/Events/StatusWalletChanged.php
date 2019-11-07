<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StatusWalletChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $wallet_address;

    public $amount;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($wallet_address, $amount)
    {
        $this->wallet_address = $wallet_address;
        $this->amount  = $amount;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['status-transaction'];
    }
}