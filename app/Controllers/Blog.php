<?php

namespace App\Controllers;

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
            'title' => 'Blog Posts',
            'posts' => $this->blogModel->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('blog/index', $data);
    }

    public function view($slug)
    {
        $post = $this->blogModel->where('slug', $slug)->first();

        if (!$post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => $post['title'],
            'post' => $post
        ];

        return view('blog/view', $data);
    }
}

