<?php

namespace App\Controllers;

use App\Models\PharmacyDrugModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
// use App\Models\NotificationModel;
use App\Models\CartModel;
// use App\Libraries\MessageQueue;
use App\Models\DeliveryJobModel;
use App\Models\DeliveryPartnerModel;

class Order extends BaseController
{
    protected $pharmacyDrugModel;
    protected $orderModel;
    protected $orderItemModel;
    protected $notificationModel;
    protected $cartModel;
    protected $db;
    protected $messageQueue;

    public function __construct()
    {
        $this->pharmacyDrugModel = new PharmacyDrugModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        // $this->notificationModel = new NotificationModel();
        $this->cartModel = new CartModel();
        $this->db = \Config\Database::connect();
        // $this->messageQueue = new MessageQueue();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Please login to view your orders.');
        }

        $data['orders'] = $this->orderModel->getUserOrders($userId);
        return view('order/index', $data);
    }

    public function add($pharmacyDrugId)
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Please login to add items to your cart.');
        }

        $pharmacyDrug = $this->pharmacyDrugModel->find($pharmacyDrugId);

        if ($pharmacyDrug) {
            $existingItem = $this->cartModel->where('user_id', $userId)
                                            ->where('pharmacy_drug_id', $pharmacyDrugId)
                                            ->first();

            if ($existingItem) {
                // If the item exists, increment the quantity
                $this->cartModel->update($existingItem['id'], [
                    'quantity' => $existingItem['quantity'] + 1
                ]);
            } else {
                // If it's a new item, add it to the cart
                $this->cartModel->insert([
                    'user_id' => $userId,
                    'pharmacy_drug_id' => $pharmacyDrugId,
                    'quantity' => 1
                ]);
            }

            return redirect()->back()->with('success', 'Item added to cart successfully');
        }

        return redirect()->back()->with('error', 'Item not found');
    }

    public function cart()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Please login to view your cart.');
        }

        $cartItems = $this->cartModel->getUserCartItems($userId);
        $total = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $cartItems));

        return view('order/cart', ['cart_items' => $cartItems, 'total' => $total]);
    }

    public function create()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method.'
            ]);
        }

        $rules = [
            'fullName' => 'required|min_length[3]',
            'phone' => 'required|min_length[10]',
            'address' => 'required|min_length[10]',
            'payment_method' => 'required|in_list[card,mobile_money,cash]',
            'delivery_option' => 'required|in_list[standard,express]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $userId = session()->get('user_id');
        if (!$userId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User not logged in.'
            ]);
        }

        $cartItems = $this->cartModel->getUserCartItems($userId);
        if (empty($cartItems)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Your cart is empty.'
            ]);
        }

        $this->db->transStart();

        try {
            $totalAmount = array_sum(array_map(function($item) {
                return $item['price'] * $item['quantity'];
            }, $cartItems));

            $deliveryFee = $this->request->getPost('delivery_option') === 'express' ? 5000 : 3000;
            $totalAmount += $deliveryFee;

            // Get pharmacy_id from the first item in the cart
            $pharmacyId = $cartItems[0]['pharmacy_id'];

            $orderData = [
                'user_id' => $userId,
                'pharmacy_id' => $pharmacyId,
                'total_amount' => $totalAmount,
                'delivery_fee' => $deliveryFee,
                'payment_method' => $this->request->getPost('payment_method'),
                'delivery_option' => $this->request->getPost('delivery_option'),
                'status' => 'pending',
                'delivery_address' => $this->request->getPost('address'),
                'delivery_type' => 'home_delivery', // Assuming home delivery for now
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $orderId = $this->orderModel->insert($orderData);

            if (!$orderId) {
                throw new \Exception('Failed to create order');
            }

            foreach ($cartItems as $item) {
                // Ensure drug_id is included
                if (!isset($item['drug_id'])) {
                    throw new \Exception('Missing drug_id for cart item');
                }

                $orderItemData = [
                    'order_id' => $orderId,
                    'pharmacy_drug_id' => $item['pharmacy_drug_id'],
                    'drug_id' => $item['drug_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ];

                log_message('debug', 'Order Item Data: ' . json_encode($orderItemData));

                if (!$this->orderItemModel->insert($orderItemData)) {
                    throw new \Exception('Failed to add order item: ' . json_encode($this->orderItemModel->errors()));
                }

                // Update stock
                $this->pharmacyDrugModel->set('stock', 'stock - ' . $item['quantity'], false)
                                        ->where('id', $item['pharmacy_drug_id'])
                                        ->update();
            }

            // Clear the cart
            $this->cartModel->where('user_id', $userId)->delete();

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Transaction failed');
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Order created successfully',
                'redirect' => base_url('order/confirmation/' . $orderId)
            ]);

        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', 'Order creation failed: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'An error occurred while processing your order: ' . $e->getMessage()
            ]);
        }
    }

    public function confirmation($orderId)
    {
        $order = $this->orderModel->find($orderId);
        if (!$order) {
            return redirect()->to('/')->with('error', 'Order not found.');
        }
        
        // Ensure items key is always set
        $order['items'] = $this->orderItemModel->getOrderItems($orderId) ?? [];

        $data['order'] = $order;
        return view('order/confirmation', $data);
    }

    public function history()
    {
        $userId = session()->get('user_id');
        $orders = $this->orderModel->where('user_id', $userId)
                                   ->orderBy('created_at', 'DESC')
                                   ->findAll();

        return view('order/history', ['orders' => $orders]);
    }

    public function reorder($orderId)
    {
        $order = $this->orderModel->find($orderId);
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found');
        }

        $orderItems = $this->orderItemModel->where('order_id', $orderId)->findAll();

        $cart = [];
        foreach ($orderItems as $item) {
            $cart[] = [
                'user_id' => session()->get('user_id'),
                'pharmacy_drug_id' => $item['pharmacy_drug_id'],
                'quantity' => $item['quantity']
            ];
        }

        $this->cartModel->insertBatch($cart);

        return redirect()->to('order/cart')->with('success', 'Items from previous order added to cart');
    }
    
    public function track($orderId)
    {
        $order = $this->orderModel->find($orderId);
        if (!$order) {
            return redirect()->to('/')->with('error', 'Order not found.');
        }
        
        $data['order'] = $order;
        $data['tracking'] = $this->orderModel->getTracking($orderId);
        return view('order/track', $data);
    }   
    public function view($orderId)
    {
        $orderModel = new OrderModel();
        $deliveryJobModel = new DeliveryJobModel();
        $deliveryPartnerModel = new DeliveryPartnerModel();
    
        // Fetch order details
        $order = $orderModel->find($orderId);
    
        if (!$order) {
            return redirect()->to('/')->with('error', 'Order not found.');
        }
    
        // Fetch delivery job details
        $deliveryJob = $deliveryJobModel->where('order_id', $orderId)->first();
    
        if ($deliveryJob) {
            // Fetch delivery partner details
            $deliveryPartner = $deliveryPartnerModel->find($deliveryJob['delivery_partner_id']);
            $order['delivery_person'] = $deliveryPartner['name'];
            $order['estimated_time'] = $deliveryJob['estimated_delivery_time'];
        }
    
        // Fetch order items
        $order['items'] = $this->orderItemModel->getOrderItems($orderId);
    
        return view('user/order_view', ['order' => $order]);
    }

    public function checkout()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Please login to checkout.');
        }

        $cartItems = $this->cartModel->getUserCartItems($userId);
        if (empty($cartItems)) {
            return redirect()->to('/cart')->with('error', 'Your cart is empty.');
        }

        $total = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $cartItems));

        return view('order/checkout', ['cart' => $cartItems, 'total' => $total]);
    }

}

