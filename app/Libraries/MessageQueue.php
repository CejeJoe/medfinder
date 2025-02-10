<?php

namespace App\Libraries;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class MessageQueue
{
    private $connection;
    private $channel;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $this->channel = $this->connection->channel();
    }

    public function publishMessage($queue, $message)
    {
        $this->channel->queue_declare($queue, false, true, false, false);
        $msg = new AMQPMessage(json_encode($message));
        $this->channel->basic_publish($msg, '', $queue);
    }

    public function consumeMessage($queue, $callback)
    {
        $this->channel->queue_declare($queue, false, true, false, false);
        $this->channel->basic_consume($queue, '', false, true, false, false, $callback);

        while (count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}

