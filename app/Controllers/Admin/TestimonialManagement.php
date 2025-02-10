<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TestimonialModel;

class TestimonialManagement extends BaseController
{
    protected $testimonialModel;

    public function __construct()
    {
        $this->testimonialModel = new TestimonialModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manage Testimonials',
            'testimonials' => $this->testimonialModel->getTestimonialsWithUserInfo(100) // Get more testimonials for admin view
        ];

        return view('admin/testimonials/index', $data);
    }

    public function add()
    {
        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'user_id' => 'required|integer',
                'content' => 'required|min_length[10]|max_length[500]',
                'rating' => 'required|integer|less_than_equal_to[5]|greater_than_equal_to[1]'
            ];

            if ($this->validate($rules)) {
                $this->testimonialModel->save([
                    'user_id' => $this->request->getPost('user_id'),
                    'content' => $this->request->getPost('content'),
                    'rating' => $this->request->getPost('rating')
                ]);

                return redirect()->to('/admin/testimonials')->with('success', 'Testimonial added successfully');
            } else {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }

        $data = [
            'title' => 'Add Testimonial'
        ];

        return view('admin/testimonials/add', $data);
    }

    public function edit($id = null)
    {
        if ($id === null) {
            return redirect()->to('/admin/testimonials')->with('error', 'No testimonial ID provided');
        }

        $testimonial = $this->testimonialModel->find($id);

        if ($testimonial === null) {
            return redirect()->to('/admin/testimonials')->with('error', 'Testimonial not found');
        }

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'content' => 'required|min_length[10]|max_length[500]',
                'rating' => 'required|integer|less_than_equal_to[5]|greater_than_equal_to[1]'
            ];

            if ($this->validate($rules)) {
                $this->testimonialModel->update($id, [
                    'content' => $this->request->getPost('content'),
                    'rating' => $this->request->getPost('rating')
                ]);

                return redirect()->to('/admin/testimonials')->with('success', 'Testimonial updated successfully');
            } else {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }

        $data = [
            'title' => 'Edit Testimonial',
            'testimonial' => $testimonial
        ];

        return view('admin/testimonials/edit', $data);
    }

    public function delete($id = null)
    {
        if ($id === null) {
            return redirect()->to('/admin/testimonials')->with('error', 'No testimonial ID provided');
        }

        if ($this->testimonialModel->delete($id)) {
            return redirect()->to('/admin/testimonials')->with('success', 'Testimonial deleted successfully');
        }

        return redirect()->to('/admin/testimonials')->with('error', 'Failed to delete testimonial');
    }
}

