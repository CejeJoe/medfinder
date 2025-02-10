<?php

namespace App\Models;

use CodeIgniter\Model;

class DrugApprovalModel extends Model
{
    protected $table = 'drug_approvals';
    protected $primaryKey = 'id';
    protected $allowedFields = ['drug_id', 'status', 'admin_notes'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getPendingApprovals()
    {
        return $this->select('drug_approvals.*, drugs.name as drug_name, drugs.category')
                    ->join('drugs', 'drugs.id = drug_approvals.drug_id')
                    ->where('drug_approvals.status', 'pending')
                    ->findAll();
    }

    public function approveDrug($id, $adminNotes)
    {
        return $this->update($id, [
            'status' => 'approved',
            'admin_notes' => $adminNotes
        ]);
    }

    public function rejectDrug($id, $adminNotes)
    {
        return $this->update($id, [
            'status' => 'rejected',
            'admin_notes' => $adminNotes
        ]);
    }
}

