<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\PharmacyDrugModel;

class Checkout extends BaseController
{
    protected $orderModel;
    protected $pharmacyDrugModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->pharmacyDrugModel = new PharmacyDrugModel();
    }

    public function index()
    {
        $cart = session()->get('cart') ?? [];
        
        if (empty($cart)) {
            return redirect()->to('/cart')->with('error', 'Your cart is empty.');
        }

        $data['cart_items'] = $this->getCartItems($cart);
        $data['total'] = $this->calculateTotal($data['cart_items']);

        return view('checkout/index', $data);
    }

    public function process()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('/checkout');
        }

        $rules = [
            'full_name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email',
            'address' => 'required|min_length[10]|max_length[255]',
            'city' => 'required|min_length[2]|max_length[100]',
            'country' => 'required|min_length[2]|max_length[100]',
            'zip_code' => 'required|min_length[5]|max_length[20]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $cart = session()->get('cart') ?? [];
        $cartItems = $this->getCartItems($cart);
        $total = $this->calculateTotal($cartItems);

        $orderData = [
            'user_id' => session()->get('user_id'),
            'total_amount' => $total,
            'status' => 'pending',
            'shipping_address' => $this->request->getPost('address') . ', ' . $this->request->getPost('city') . ', ' . $this->request->getPost('country') . ' ' . $this->request->getPost('zip_code'),
        ];

        $orderId = $this->orderModel->insert($orderData);

        foreach ($cartItems as $item) {
            $this->orderModel->addOrderItem($orderId, $item['id'], $item['quantity'], $item['price']);
            $this->pharmacyDrugModel->updateStock($item['id'], $item['quantity']);
        }

        session()->remove('cart');

        return redirect()->to('/checkout/confirmation/' . $orderId);
    }

    public function confirmation($orderId)
    {
        $order = $this->orderModel->find($orderId);
        
        if (!$order) {
            return redirect()->to('/')->with('error', 'Order not found.');
        }

        $data['order'] = $order;
        $data['order_items'] = $this->orderModel->getOrderItems($orderId);

        return view('checkout/confirmation', $data);
    }

    private function getCartItems($cart)
    {
        $items = [];
        foreach ($cart as $id => $item) {
            $drugInfo = $this->pharmacyDrugModel->find($id);
            if ($drugInfo) {
                $items[] = [
                    'id' => $id,
                    'name' => $drugInfo['drug_name'],
                    'price' => $drugInfo['price'],
                    'quantity' => $item['quantity'],
                ];
            }
        }
        return $items;
    }

    private function calculateTotal($items)
    {
        return array_reduce($items, function($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
    }
}

