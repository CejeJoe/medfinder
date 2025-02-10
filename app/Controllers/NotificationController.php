<?php

namespace App\Controllers;

use App\Models\NotificationModel;

class NotificationController extends BaseController
{
    protected $notificationModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $data['notifications'] = $this->notificationModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll();
        return view('notifications/index', $data);
    }

    public function getUnreadNotifications()
    {
        $userId = session()->get('user_id');
        $notifications = $this->notificationModel->getUnreadNotifications($userId);
        return $this->response->setJSON($notifications);
    }

    public function markAsRead($id)
    {
        $success = $this->notificationModel->markAsRead($id);
        return $this->response->setJSON(['success' => $success]);
    }

    public function createNotification()
    {
        $userId = $this->request->getPost('user_id');
        $type = $this->request->getPost('type');
        $message = $this->request->getPost('message');
        $relatedId = $this->request->getPost('related_id');

        $success = $this->notificationModel->addNotification($userId, $type, $message, $relatedId);

        return $this->response->setJSON(['success' => $success]);
    }

    public function getNotificationsByType($type)
    {
        $userId = session()->get('user_id');
        $notifications = $this->notificationModel->getNotificationsByType($userId, $type);
        return $this->response->setJSON($notifications);
    }
}

