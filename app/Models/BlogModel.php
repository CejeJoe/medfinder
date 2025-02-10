<?php

namespace App\Models;

use CodeIgniter\Model;

class BlogModel extends Model
{
    protected $table = 'blogs';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['title', 'slug', 'content', 'author_id', 'image_url'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [
        'title' => 'required|min_length[3]|max_length[255]',
        'slug' => 'required|min_length[3]|max_length[255]|is_unique[blogs.slug,id,{id}]',
        'content' => 'required'
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Title is required',
            'min_length' => 'Title must be at least 3 characters long',
            'max_length' => 'Title cannot exceed 255 characters'
        ],
        'slug' => [
            'required' => 'Slug is required',
            'min_length' => 'Slug must be at least 3 characters long',
            'max_length' => 'Slug cannot exceed 255 characters',
            'is_unique' => 'This slug is already in use'
        ],
        'content' => [
            'required' => 'Content is required'
        ]
    ];

    protected $skipValidation = false;

    public function getPosts($slug = null)
    {
        if ($slug === null) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }
}

