<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BlogModel;

class Blog extends BaseController
{
    protected $blogModel;

    public function __construct()
    {
        $this->blogModel = new BlogModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manage Blog Posts',
            'posts' => $this->blogModel->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('admin/blog/index', $data);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'content' => 'required'
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $slug = url_title($this->request->getPost('title'), '-', true);
            $data = [
                'title' => $this->request->getPost('title'),
                'slug' => $slug,
                'content' => $this->request->getPost('content')
            ];

            if ($this->blogModel->insert($data)) {
                return redirect()->to('admin/blog')->with('success', 'Blog post created successfully');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to create blog post');
            }
        }

        return view('admin/blog/create', ['title' => 'Create Blog Post']);
    }

    public function edit($id)
    {
        $post = $this->blogModel->find($id);

        if (!$post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'content' => 'required'
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $slug = url_title($this->request->getPost('title'), '-', true);
            $data = [
                'title' => $this->request->getPost('title'),
                'slug' => $slug,
                'content' => $this->request->getPost('content')
            ];

            if ($this->blogModel->update($id, $data)) {
                return redirect()->to('admin/blog')->with('success', 'Blog post updated successfully');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to update blog post');
            }
        }

        return view('admin/blog/edit', ['title' => 'Edit Blog Post', 'post' => $post]);
    }

    public function delete($id)
    {
        if ($this->blogModel->delete($id)) {
            return redirect()->to('admin/blog')->with('success', 'Blog post deleted successfully');
        } else {
            return redirect()->to('admin/blog')->with('error', 'Failed to delete blog post');
        }
    }
}

