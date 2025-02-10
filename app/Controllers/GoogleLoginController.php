<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Google_Client;
use Google_Service_Oauth2;
use App\Models\UserModel;

require 'vendor/autoload.php'; // Ensure this line is present to autoload the Google API Client Library

class GoogleLoginController extends Controller
{
    public function login()
    {
        $client = new Google_Client();
        $client->setClientId('763717021810-cgm4tfuujfsfdtea8uqar4797h305p4l.apps.googleusercontent.com');
        $client->setClientSecret('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');
        $client->setRedirectUri(base_url('login/google/callback'));
        $client->addScope('email');
        $client->addScope('profile');

        $authUrl = $client->createAuthUrl();
        return redirect()->to($authUrl);
    }

    public function callback()
    {
        $client = new Google_Client();
        $client->setClientId('763717021810-cgm4tfuujfsfdtea8uqar4797h305p4l.apps.googleusercontent.com');
        $client->setClientSecret('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');
        $client->setRedirectUri(base_url('login/google/callback'));

        if ($this->request->getVar('code')) {
            try {
                $token = $client->fetchAccessTokenWithAuthCode($this->request->getVar('code'));
                if (isset($token['error'])) {
                    throw new \Exception($token['error_description']);
                }
                $client->setAccessToken($token['access_token']);

                $googleService = new Google_Service_Oauth2($client);
                $userData = $googleService->userinfo->get();

                // Process user data and log in the user
                $this->processUserData($userData);

                return redirect()->to($this->getRedirectUrl());
            } catch (\Exception $e) {
                return redirect()->to('/login')->with('error', 'Failed to authenticate with Google: ' . $e->getMessage());
            }
        } else {
            return redirect()->to('/login')->with('error', 'Failed to authenticate with Google.');
        }
    }

    private function processUserData($userData)
    {
        $userModel = new UserModel();
        $user = $userModel->where('email', $userData->email)->first();

        if (!$user) {
            // Create a new user if not exists
            $userModel->insert([
                'username' => $userData->name,
                'email' => $userData->email,
                'google_id' => $userData->id,
                'profile_picture' => $userData->picture,
            ]);
            $user = $userModel->where('email', $userData->email)->first();
        }

        // Set user session data
        $session = session();
        $session->set('user', [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'role' => $user['role'],
            'profile_picture' => $user['profile_picture'],
        ]);
    }

    private function getRedirectUrl()
    {
        $session = session();
        $user = $session->get('user');

        switch ($user['role']) {
            case 'super_admin':
                return 'https://admin.chrisbertconsult.org';
            case 'pharmacy_admin':
                return 'https://pharmacy.chrisbertconsult.org';
            case 'driver':
                return 'https://driver.chrisbertconsult.org';
            case 'user':
                return 'https://user.chrisbertconsult.org';
            default:
                return '/';
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
