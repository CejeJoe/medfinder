<?php

namespace App\Controllers;

use App\Models\UserDrugModel;

class UserDrugs extends BaseController
{
    protected $userDrugModel;

    public function __construct()
    {
        $this->userDrugModel = new UserDrugModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $drugs = $this->userDrugModel->getUserDrugs($userId);

        $data = [
            'title' => 'Your Drugs',
            'drugs' => $drugs
        ];

        return view('user/drugs', $data);
    }

    public function add()
    {
        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'name' => 'required|min_length[3]|max_length[100]',
                'dosage' => 'required',
                'frequency' => 'required',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $data = [
                'user_id' => session()->get('user_id'),
                'name' => $this->request->getPost('name'),
                'dosage' => $this->request->getPost('dosage'),
                'frequency' => $this->request->getPost('frequency'),
                'notes' => $this->request->getPost('notes'),
            ];

            if ($this->userDrugModel->insert($data)) {
                return redirect()->to('user/drugs')->with('success', 'Drug added successfully');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to add drug');
            }
        }

        return view('user/add_drug');
    }

    public function edit($id)
    {
        $drug = $this->userDrugModel->find($id);

        if (!$drug || $drug['user_id'] !== session()->get('user_id')) {
            return redirect()->to('user/drugs')->with('error', 'Drug not found');
        }

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'name' => 'required|min_length[3]|max_length[100]',
                'dosage' => 'required',
                'frequency' => 'required',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $data = [
                'name' => $this->request->getPost('name'),
                'dosage' => $this->request->getPost('dosage'),
                'frequency' => $this->request->getPost('frequency'),
                'notes' => $this->request->getPost('notes'),
            ];

            if ($this->userDrugModel->update($id, $data)) {
                return redirect()->to('user/drugs')->with('success', 'Drug updated successfully');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to update drug');
            }
        }

        $data = [
            'title' => 'Edit Drug',
            'drug' => $drug
        ];

        return view('user/edit_drug', $data);
    }

    public function delete($id)
    {
        $drug = $this->userDrugModel->find($id);

        if (!$drug || $drug['user_id'] !== session()->get('user_id')) {
            return redirect()->to('user/drugs')->with('error', 'Drug not found');
        }

        if ($this->userDrugModel->delete($id)) {
            return redirect()->to('user/drugs')->with('success', 'Drug deleted successfully');
        } else {
            return redirect()->to('user/drugs')->with('error', 'Failed to delete drug');
        }
    }
}

