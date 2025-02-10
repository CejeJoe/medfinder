<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SubscriptionPlanModel;

class SubscriptionPlanController extends BaseController
{
    protected $subscriptionPlanModel;

    public function __construct()
    {
        $this->subscriptionPlanModel = new SubscriptionPlanModel();
    }

    public function index()
    {
        $data['subscriptionPlans'] = $this->subscriptionPlanModel->findAll();
        return view('admin/subscription_plans/index', $data);
    }

    public function create()
    {
        return view('admin/subscription_plans/create');
    }

    public function store()
    {
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => 'required|min_length[3]|max_length[255]',
                'price' => 'required|numeric',
                'duration' => 'required|integer',
                'status' => 'required|in_list[active,inactive]'
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $features = $this->request->getPost('features');

            $data = [
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
                'price' => $this->request->getPost('price'),
                'duration' => $this->request->getPost('duration'),
                'features' => $this->subscriptionPlanModel->setFeatures($features),
                'status' => $this->request->getPost('status')
            ];

            $this->subscriptionPlanModel->insert($data);
            return redirect()->to('/admin/subscription-plans')->with('success', 'Subscription plan created successfully');
        }
    }

    public function edit($id)
    {
        $data['plan'] = $this->subscriptionPlanModel->find($id);
        return view('admin/subscription_plans/edit', $data);
    }

    public function update($id)
    {
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => 'required|min_length[3]|max_length[255]',
                'price' => 'required|numeric',
                'duration' => 'required|integer',
                'status' => 'required|in_list[active,inactive]'
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $data = [
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
                'price' => $this->request->getPost('price'),
                'duration' => $this->request->getPost('duration'),
                'features' => json_encode($this->request->getPost('features')),
                'status' => $this->request->getPost('status')
            ];

            $this->subscriptionPlanModel->update($id, $data);
            return redirect()->to('/admin/subscription-plans')->with('success', 'Subscription plan updated successfully');
        }
    }

    public function delete($id)
    {
        $this->subscriptionPlanModel->delete($id);
        return redirect()->to('/admin/subscription-plans')->with('success', 'Subscription plan deleted successfully');
    }
}

