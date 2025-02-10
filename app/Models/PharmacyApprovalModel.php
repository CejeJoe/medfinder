<?php

namespace App\Models;

use CodeIgniter\Model;

class PharmacyApprovalModel extends Model
{
    protected $table = 'pharmacy_approvals';
    protected $primaryKey = 'id';
    protected $allowedFields = ['pharmacy_id', 'status', 'admin_notes'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getPendingApprovals()
    {
        return $this->select('pharmacy_approvals.*, pharmacies.name as pharmacy_name, pharmacies.address, users.email')
                    ->join('pharmacies', 'pharmacies.id = pharmacy_approvals.pharmacy_id')
                    ->join('users', 'users.id = pharmacies.user_id')
                    ->where('pharmacy_approvals.status', 'pending')
                    ->findAll();
    }

    public function approvePharmacy($id, $adminNotes)
    {
        return $this->update($id, [
            'status' => 'approved',
            'admin_notes' => $adminNotes
        ]);
    }

    public function rejectPharmacy($id, $adminNotes)
    {
        return $this->update($id, [
            'status' => 'rejected',
            'admin_notes' => $adminNotes
        ]);
    }
}

