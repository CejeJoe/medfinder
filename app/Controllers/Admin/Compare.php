<?php

namespace App\Controllers;

class Compare extends BaseController
{
    public function add()
    {
        $id = $this->request->getPost('id');
        $compareList = session()->get('compare') ?? [];

        if (!in_array($id, $compareList) && count($compareList) < 3) {
            $compareList[] = $id;
            session()->set('compare', $compareList);
            return $this->response->setJSON(['success' => true]);
        }

        return $this->response->setJSON(['success' => false]);
    }
}

