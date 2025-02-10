<?php

namespace App\Controllers;

use App\Models\SupportTicketModel;
use App\Models\FeedbackModel;

class Support extends BaseController
{
    protected $supportTicketModel;
    protected $feedbackModel;

    public function __construct()
    {
        $this->supportTicketModel = new SupportTicketModel();
        $this->feedbackModel = new FeedbackModel();
    }

    public function index()
    {
        return view('support/index');
    }

    public function submitTicket()
    {
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'subject' => 'required|min_length[5]|max_length[100]',
                'message' => 'required|min_length[10]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $data = [
                'user_id' => session()->get('user_id'),
                'subject' => $this->request->getPost('subject'),
                'message' => $this->request->getPost('message'),
                'status' => 'open',
            ];

            $this->supportTicketModel->insert($data);
            return redirect()->to('support')->with('success', 'Your support ticket has been submitted.');
        }

        return redirect()->back();
    }

    public function submitFeedback()
    {
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'rating' => 'required|integer|between[1,5]',
                'comment' => 'required|min_length[10]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $data = [
                'user_id' => session()->get('user_id'),
                'order_id' => $this->request->getPost('order_id'),
                'rating' => $this->request->getPost('rating'),
                'comment' => $this->request->getPost('comment'),
            ];

            $this->feedbackModel->insert($data);
            return redirect()->to('order/history')->with('success', 'Thank you for your feedback.');
        }

        return redirect()->back();
    }
}

