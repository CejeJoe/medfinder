<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\PharmacyDrugModel;

class Cart extends BaseController
{
    protected $cartModel;
    protected $pharmacyDrugModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->pharmacyDrugModel = new PharmacyDrugModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        // if (!$userId) {
        //     return redirect()->to('/login')->with('error', 'Please login to view your cart.');
        // }

        $data['cart_items'] = $this->cartModel->getUserCartItems($userId);
        $data['total'] = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $data['cart_items']));

        return view('cart/index', $data);
    }

    public function add()
    {
        // Verify AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request method']);
        }

        $userId = session()->get('user_id');
        if (!$userId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Please login to add items to cart.']);
        }

        // Validate input
        $drugId = $this->request->getPost('id');
        if (!$drugId) {
            return $this->response->setJSON(['success' => false, 'message' => 'No product specified']);
        }
        
        $quantity = (int)($this->request->getPost('quantity') ?? 1);
        if ($quantity < 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid quantity']);
        }

        // Check if drug exists and get its details
        $pharmacyDrug = $this->pharmacyDrugModel->find($drugId);
        if (!$pharmacyDrug) {
            return $this->response->setJSON(['success' => false, 'message' => 'Product not found']);
        }

        try {
            // Add to cart
            $success = $this->cartModel->addToCart($userId, $drugId, $quantity, $pharmacyDrug['price']);
            
            if (!$success) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to add item to cart: Database operation failed'
                ]);
            }
            
            // Get updated cart count
            $cartCount = count($this->cartModel->getUserCartItems($userId));

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Item added to cart successfully',
                'cartCount' => $cartCount
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Cart addition failed: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to add item to cart'
            ]);
        }
    }

    public function remove()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Please login to remove items from cart.']);
        }

        $drugId = $this->request->getPost('id');

        $this->cartModel->removeFromCart($userId, $drugId);

        $cartCount = count($this->cartModel->getCartItems($userId));

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Item removed from cart successfully.',
            'cartCount' => $cartCount
        ]);
    }

    public function update()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Please login to update your cart.');
        }

        $updates = $this->request->getPost('quantities');

        foreach ($updates as $drugId => $quantity) {
            $this->cartModel->updateQuantity($userId, $drugId, $quantity);
        }

        return redirect()->to('/cart')->with('success', 'Cart updated successfully.');
    }
}

