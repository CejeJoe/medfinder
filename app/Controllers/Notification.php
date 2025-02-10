<?php

namespace App\Controllers;

use App\Models\NotificationModel;

class Notification extends BaseController
{
    protected $notificationModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $notifications = $this->notificationModel->where('user_id', $userId)
                                                 ->orderBy('created_at', 'DESC')
                                                 ->findAll();

        return view('notifications/index', ['notifications' => $notifications]);
    }

    public function markAsRead($id)
    {
        $this->notificationModel->markAsRead($id);
        return redirect()->back();
    }

    public function getUnread()
    {
        $userId = session()->get('user_id');
        $unreadNotifications = $this->notificationModel->getUnreadNotifications($userId);
        return $this->response->setJSON($unreadNotifications);
    }
}

