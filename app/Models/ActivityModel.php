<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityModel extends Model
{
    protected $table = 'activities';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['user_id', 'action', 'description', 'entity_type', 'entity_id'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getRecentActivities($limit = 5)
    {
        return $this->select('activities.*, users.username')
                    ->join('users', 'users.id = activities.user_id')
                    ->orderBy('activities.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function logActivity($userId, $action, $description, $entityType = null, $entityId = null)
    {
        $data = [
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
            'entity_type' => $entityType,
            'entity_id' => $entityId
        ];

        return $this->insert($data);
    }
}

