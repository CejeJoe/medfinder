<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\OrderModel;
use App\Libraries\MessageQueue;

class ProcessOrders extends BaseCommand
{
    protected $group       = 'MedFinder';
    protected $name        = 'medfinder:process-orders';
    protected $description = 'Process orders from the message queue';

    public function run(array $params)
    {
        $messageQueue = new MessageQueue();
        $orderModel = new OrderModel();

        CLI::write("Waiting for orders. To exit press CTRL+C");

        $callback = function ($msg) use ($orderModel) {
            $orderData = json_decode($msg->body, true);
            CLI::write("Processing order: " . $orderData['order_id']);

            $orderModel->processOrder($orderData['order_id']);
        };

        $messageQueue->consumeMessage('order_processing', $callback);
    }
}

