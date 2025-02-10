<?php

namespace App\Controllers;

class Favorites extends BaseController
{
    public function toggle()
    {
        $id = $this->request->getPost('id');
        $favorites = session()->get('favorites') ?? [];

        if (in_array($id, $favorites)) {
            $favorites = array_diff($favorites, [$id]);
        } else {
            $favorites[] = $id;
        }

        session()->set('favorites', $favorites);

        return $this->response->setJSON(['success' => true]);
    }
}

