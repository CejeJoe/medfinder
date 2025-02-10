<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PharmacyModel;
use App\Models\PharmacyApprovalModel;
use App\Models\NotificationModel;

class PharmacyManagement extends BaseController
{
    protected $pharmacyModel;
    protected $pharmacyApprovalModel;
    protected $notificationModel;

    public function __construct()
    {
        $this->pharmacyModel = new PharmacyModel();
        $this->pharmacyApprovalModel = new PharmacyApprovalModel();
        $this->notificationModel = new NotificationModel();
    }

    public function index()
    {
        $data['pharmacies'] = $this->pharmacyModel->findAll();
        return view('admin/pharmacy_management/index', $data);
    }

    public function pendingApprovals()
    {
        $data['pending_approvals'] = $this->pharmacyApprovalModel->getPendingApprovals();
        return view('admin/pharmacy_management/pending_approvals', $data);
    }

    public function approve($id)
    {
        $adminNotes = $this->request->getPost('admin_notes');
        if ($this->pharmacyApprovalModel->approvePharmacy($id, $adminNotes)) {
            $this->pharmacyModel->update($id, ['status' => 'active']);
            
            // Create notification for pharmacy owner
            $pharmacy = $this->pharmacyModel->find($id);
            $this->notificationModel->createNotification(
                $pharmacy['user_id'],
                "Your pharmacy has been approved",
                'account'
            );

            return redirect()->to('/admin/pharmacies/pending')->with('success', 'Pharmacy approved successfully');
        }
        return redirect()->back()->with('error', 'Failed to approve pharmacy');
    }

    public function reject($id)
    {
        $adminNotes = $this->request->getPost('admin_notes');
        if ($this->pharmacyApprovalModel->rejectPharmacy($id, $adminNotes)) {
            $this->pharmacyModel->update($id, ['status' => 'rejected']);
            
            // Create notification for pharmacy owner
            $pharmacy = $this->pharmacyModel->find($id);
            $this->notificationModel->createNotification(
                $pharmacy['user_id'],
                "Your pharmacy application has been rejected",
                'account'
            );

            return redirect()->to('/admin/pharmacies/pending')->with('success', 'Pharmacy rejected successfully');
        }
        return redirect()->back()->with('error', 'Failed to reject pharmacy');
    }

    public function toggleActive($id)
    {
        $pharmacy = $this->pharmacyModel->find($id);
        $newStatus = $pharmacy['is_active'] ? 'inactive' : 'active';
        if ($this->pharmacyModel->update($id, ['is_active' => !$pharmacy['is_active']])) {
            // Create notification for pharmacy owner
            $this->notificationModel->createNotification(
                $pharmacy['user_id'],
                "Your pharmacy status has been updated to {$newStatus}",
                'account'
            );

            return redirect()->back()->with('success', "Pharmacy status updated to {$newStatus}");
        }
        return redirect()->back()->with('error', 'Failed to update pharmacy status');
    }
    public function edit($id)
    {
        $pharmacy = $this->pharmacyModel->find($id);

        if (!$pharmacy) {
            return redirect()->to('/admin/pharmacies')->with('error', 'Pharmacy not found');
        }

        if ($this->request->getMethod() === 'post') {
            $data = $this->request->getPost();
            if ($this->pharmacyModel->update($id, $data)) {
                return redirect()->to('/admin/pharmacies')->with('success', 'Pharmacy updated successfully');
            } else {
                return redirect()->back()->withInput()->with('errors', $this->pharmacyModel->errors());
            }
        }

        return view('admin/pharmacy_management/edit', ['pharmacy' => $pharmacy]);
    }

    public function view($id)
    {
        $pharmacy = $this->pharmacyModel->find($id);

        if (!$pharmacy) {
            return redirect()->to('/admin/pharmacies')->with('error', 'Pharmacy not found');
        }

        return view('admin/pharmacy_management/view', ['pharmacy' => $pharmacy]);
    }

    public function delete($id)
    {
        if ($this->pharmacyModel->delete($id)) {
            return redirect()->to('/admin/pharmacies')->with('success', 'Pharmacy deleted successfully');
        }

        return redirect()->to('/admin/pharmacies')->with('error', 'Failed to delete pharmacy');
    }
    public function add()
    {
        if ($this->request->getMethod() === 'post') {
            $data = $this->request->getPost();
            if ($this->pharmacyModel->insert($data)) {
                return redirect()->to('/admin/pharmacies')->with('success', 'Pharmacy added successfully');
            } else {
                return redirect()->back()->withInput()->with('errors', $this->pharmacyModel->errors());
            }
        }

        return view('admin/pharmacy_management/add');
    }
}