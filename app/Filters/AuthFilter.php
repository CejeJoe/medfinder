<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(\CodeIgniter\HTTP\RequestInterface $request, $arguments = null)
    {
        $session = session();
    
        // Check if the user is not logged in
        if (!$session->get('logged_in')) {
            $currentUrl = current_url(); // Get the current URL
            $queryString = $request->getUri()->getQuery(); // Include query strings if any
    
            // Save the intended URL in the session
            $session->set('redirect_url', $queryString ? $currentUrl . '?' . $queryString : $currentUrl);
    
            // Redirect to login
            return redirect()->to('/login');
        }
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No post-processing needed for this filter
    }
}
