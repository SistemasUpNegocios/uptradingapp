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
  public $id;

  public function __construct($message, $image, $id)
  {
      $this->message = $message;
      $this->image = $image;
      $this->id = $id;
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