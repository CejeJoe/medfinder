<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PharmacyModel;
use PragmaRX\Google2FA\Google2FA;

class Auth extends BaseController
{
    protected $userModel;
    protected $pharmacyModel;
    protected $google2fa;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->pharmacyModel = new PharmacyModel();
        // $this->google2fa = new Google2FA();
    }

    public function login()
    {
        // Capture the intended URL before displaying the login page
        $redirectUrl = $this->request->getVar('redirect_url');
        if ($redirectUrl) {
            session()->set('redirect_url', $redirectUrl);
        }

        return view('auth/login');
    }

    public function authenticate()
    {
        if ($this->request->getMethod() === 'POST') {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            // Get the user from the database
            $userModel = new UserModel();
            $user = $userModel->where('email', $email)->first();

            if ($user) {
                // Check if the entered password matches the stored hash
                if (password_verify($password, $user['password'])) {
                    // Set session data
                    $session = session();
                    $session->set([
                        'user_id' => $user['id'],
                        'username' => $user['username'],
                        'email' => $user['email'],
                        'role' => $user['role'],
                        'logged_in' => true,
                    ]);

                    // Get the pharmacy_id for the user
                    $pharmacyModel = new PharmacyModel();
                    $pharmacy = $pharmacyModel->where('user_id', $user['id'])->first();

                    if ($pharmacy) {
                        $session->set('pharmacy_id', $pharmacy['id']); // Store the pharmacy_id in the session
                    }

                    // Redirect to the originally requested page
                    $redirectUrl = $session->get('redirect_url');
                    if ($redirectUrl) {
                        $session->remove('redirect_url'); // Remove it from the session to avoid loops
                        return redirect()->to($redirectUrl);
                    }

                    // Default redirection logic based on role
                    $redirectUrls = [
                        'super_admin'     => 'https://admin.chrisbertconsult.org',
                        'pharmacy_admin'  => 'https://pharmacy.chrisbertconsult.org',
                        'driver'          => 'https://driver.chrisbertconsult.org',
                        'user'            => 'https://user.chrisbertconsult.org',
                    ];

                    // Check if the user's role exists in the array
                    if (array_key_exists($user['role'], $redirectUrls)) {
                        return redirect()->to($redirectUrls[$user['role']])->withCookies();
                    }

                    // Default redirect if role is unknown
                    return redirect()->to('/')->with('error', 'Unknown role.');

                } else {
                    return redirect()->back()->with('error', 'Invalid email or password');
                }
            } else {
                return redirect()->back()->with('error', 'Invalid email or password');
            }
        }

        return redirect()->to('/login');
    }

    public function verify2fa($userId)
    {
        if ($this->request->getMethod() === 'POST') {
            $user = $this->userModel->find($userId);
            $code = $this->request->getPost('code');

            if ($this->google2fa->verifyKey($user['two_factor_secret'], $code)) {
                $this->setUserSession($user);
                return redirect()->to('/dashboard');
            } else {
                return redirect()->back()->with('error', 'Invalid 2FA code');
            }
        }

        return view('auth/verify2fa');
    }

    public function enable2fa()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if (!$user['two_factor_secret']) {
            $secret = $this->google2fa->generateSecretKey();
            $this->userModel->update($userId, ['two_factor_secret' => $secret]);

            $qrCodeUrl = $this->google2fa->getQRCodeUrl(
                'MedFinder',
                $user['email'],
                $secret
            );

            return view('auth/enable2fa', ['qrCodeUrl' => $qrCodeUrl, 'secret' => $secret]);
        }

        return redirect()->to('/profile')->with('info', '2FA is already enabled');
    }

    public function disable2fa()
    {
        $userId = session()->get('user_id');
        $this->userModel->update($userId, ['two_factor_secret' => null]);
        return redirect()->to('/profile')->with('success', '2FA has been disabled');
    }

    private function setUserSession($user)
    {
        $data = [
            'user_id' => $user['id'],
            'email' => $user['email'],
            'role' => $user['role'],
            'logged_in' => true
        ];

        session()->set($data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}

