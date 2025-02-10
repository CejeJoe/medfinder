<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username', 
        'email', 
        'password', 
        'role', 
        'phone', 
        'google_id', 
        'profile_picture'
    ];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }

        return $data;
    }
    public function findDriverById($id)
    {
        return $this->where('id', $id)
                    ->where('role', 'driver')
                    ->first();
    }
    public function registerUser($userData)
    {
      $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
      $userData['role'] = 'user'; // Default role for new registrations
      return $this->insert($userData);
    }
    public function getUserGrowth()
    {
        $currentMonth = date('Y-m');
        $lastMonth = date('Y-m', strtotime('-1 month'));

        $currentMonthUsers = $this->where('DATE_FORMAT(created_at, "%Y-%m") =', $currentMonth)->countAllResults();
        $lastMonthUsers = $this->where('DATE_FORMAT(created_at, "%Y-%m") =', $lastMonth)->countAllResults();

        if ($lastMonthUsers > 0) {
            $growthRate = (($currentMonthUsers - $lastMonthUsers) / $lastMonthUsers) * 100;
        } else {
            $growthRate = $currentMonthUsers > 0 ? 100 : 0;
        }

        return [
            'current_month' => $currentMonthUsers,
            'last_month' => $lastMonthUsers,
            'growth_rate' => $growthRate
        ];
    }
}

