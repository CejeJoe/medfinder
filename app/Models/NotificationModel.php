<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['user_id', 'type', 'message', 'is_read', 'related_id', 'created_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function addNotification($userId, $type, $message, $relatedId = null)
    {
        return $this->insert([
            'user_id' => $userId,
            'type' => $type,
            'message' => $message,
            'is_read' => false,
            'related_id' => $relatedId
        ]);
    }

    public function getUnreadNotifications($userId)
    {
        return $this->where('user_id', $userId)
                    ->where('is_read', false)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function markAsRead($id)
    {
        return $this->update($id, ['is_read' => true]);
    }

    public function getNotificationsByType($userId, $type)
    {
        return $this->where('user_id', $userId)
                    ->where('type', $type)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
    public function createNotification($userId, $message, $type)
    {
        return $this->insert([
            'user_id' => $userId,
            'message' => $message,
            'type' => $type,
            'is_read' => 0
        ]);
    }
}

