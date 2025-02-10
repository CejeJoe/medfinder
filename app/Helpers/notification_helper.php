<?php

if (!function_exists('create_notification')) {
    function create_notification($userId, $message, $type)
    {
        $notificationModel = new \App\Models\NotificationModel();
        return $notificationModel->createNotification($userId, $message, $type);
    }
}