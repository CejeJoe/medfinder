<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Settings extends BaseController
{
    public function index()
    {
        // Load current settings
        $data['settings'] = [
            'site_name' => 'MedFinder',
            'site_description' => 'Find and order medications easily',
            'contact_email' => 'contact@medfinder.com',
            'maintenance_mode' => false,
        ];

        return view('admin/settings/index', $data);
    }

    public function update()
    {
        // Validate and update settings
        $rules = [
            'site_name' => 'required|min_length[3]|max_length[255]',
            'site_description' => 'required|max_length[1000]',
            'contact_email' => 'required|valid_email',
            'maintenance_mode' => 'required|in_list[0,1]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update settings (this is a placeholder, replace with actual settings update logic)
        $updatedSettings = [
            'site_name' => $this->request->getPost('site_name'),
            'site_description' => $this->request->getPost('site_description'),
            'contact_email' => $this->request->getPost('contact_email'),
            'maintenance_mode' => (bool)$this->request->getPost('maintenance_mode'),
        ];

        // Save updated settings (implement this method based on your settings storage mechanism)
        $this->saveSettings($updatedSettings);

        return redirect()->to('/admin/settings')->with('success', 'Settings updated successfully');
    }

    private function saveSettings($settings)
    {
        // Implement the logic to save settings
        // This could involve writing to a database, updating a configuration file, etc.
        // For now, we'll just simulate the save operation
        return true;
    }
}

