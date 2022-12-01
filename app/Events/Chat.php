<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Chat implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $message;
  public $image;

  public function __construct($message, $image)
  {
      $this->message = $message;
      $this->image = $image;
  }

  public function broadcastOn()
  {
      return ['chat-channel'];
  }

  public function broadcastAs()
  {
      return 'chat-event';
  }
}