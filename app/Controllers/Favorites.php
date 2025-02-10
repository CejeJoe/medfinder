<?php

namespace App\Controllers;

class Favorites extends BaseController
{
    public function toggle()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Please log in to add favorites']);
        }

        $id = $this->request->getPost('id');
        $userId = session()->get('user_id');
        $favorites = $this->getFavorites($userId);

        if (in_array($id, $favorites)) {
            $favorites = array_diff($favorites, [$id]);
        } else {
            $favorites[] = $id;
        }

        $this->saveFavorites($userId, $favorites);

        return $this->response->setJSON(['success' => true]);
    }

    private function getFavorites($userId)
    {
        // Implement this method to get favorites from the database for the given user
        // For now, we'll use session storage
        return session()->get("favorites_{$userId}") ?? [];
    }

    private function saveFavorites($userId, $favorites)
    {
        // Implement this method to save favorites to the database for the given user
        // For now, we'll use session storage
        session()->set("favorites_{$userId}", $favorites);
    }
}

