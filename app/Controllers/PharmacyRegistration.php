    <?php

    namespace App\Controllers;

    use CodeIgniter\Controller;
    use App\Models\UserModel;
    use App\Models\PharmacyModel;
    use App\Models\NotificationModel;

    class PharmacyRegistration extends Controller
    {
        protected $db;  // Declare the db property
        protected $notificationModel;

        public function __construct()
        {
            $this->db = \Config\Database::connect();  // Initialize the db connection
            $this->notificationModel = new NotificationModel();
        }

        public function index()
        {
            helper(['form']);
            $data = [];
            return view('pharmacy_registration', $data);
        }

        public function register()
        {
            helper(['form']);
            $rules = [
                'username' => 'required|min_length[3]|max_length[20]|is_unique[users.username]',
                'email'    => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[8]',
                'passconf' => 'required|matches[password]',
                'phone'    => 'required|numeric|min_length[10]',
                'pharmacy_name' => 'required|min_length[3]|max_length[100]',
                'address'  => 'required|min_length[10]',
                // 'license_number' => 'required|alpha_numeric',
            ];

            if ($this->validate($rules)) {
                $userModel = new UserModel();
                $pharmacyModel = new PharmacyModel();

                // Start a database transaction
                $this->db->transStart();

                $userData = [
                    'username' => $this->request->getVar('username'),
                    'email'    => $this->request->getVar('email'),
                    'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                    'role'     => 'pharmacy_admin',
                    'phone'    => $this->request->getVar('phone'),
                ];

                $userId = $userModel->insert($userData);
                $superAdminId = 1; // Assuming this ID exists
                $this->notificationModel->addNotification(
                    $superAdminId,
                    'new_pharmacy',
                    "New pharmacy registered: {$userData['username']}"
                );

                $pharmacyData = [
                    'name' => $this->request->getVar('pharmacy_name'),
                    'address' => $this->request->getVar('address'),
                    'is_active' => true,
                    'user_id' => $userId,
                ];

                $pharmacyModel->insert($pharmacyData);

                // Complete the transaction
                $this->db->transComplete();

                if ($this->db->transStatus() === false) {
                    return redirect()->back()->with('error', 'Registration failed. Please try again.');
                }

                return redirect()->to('login')->with('success', 'Registration successful. Please login.');
            } else {
                // If validation fails, set the errors in session
                session()->setFlashdata('errors', $this->validator->getErrors());

                // Optionally, retain old input values
                return redirect()->back()->withInput();
            }
        }
    }
