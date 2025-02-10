<?php

namespace App\Controllers;

use App\Models\ReviewModel;
use App\Models\PharmacyModel;

class Reviews extends BaseController
{
    protected $reviewModel;
    protected $pharmacyModel;

    public function __construct()
    {
        $this->reviewModel = new ReviewModel();
        $this->pharmacyModel = new PharmacyModel();
    }

    public function create($pharmacyId)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'You must be logged in to submit a review.');
        }

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'rating' => 'required|integer',
                'comment' => 'required|min_length[10]|max_length[500]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $data = [
                'user_id' => session()->get('user_id'),
                'pharmacy_id' => $pharmacyId,
                'rating' => $this->request->getPost('rating'),
                'comment' => $this->request->getPost('comment'),
            ];

            if ($this->reviewModel->insert($data)) {
                return redirect()->to("/pharmacy/view/{$pharmacyId}")->with('success', 'Review submitted successfully');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to submit review');
            }
        }

        $pharmacy = $this->pharmacyModel->find($pharmacyId);
        if (!$pharmacy) {
            return redirect()->to('/pharmacies')->with('error', 'Pharmacy not found');
        }

        return view('reviews/create', ['pharmacy' => $pharmacy]);
    }
}

