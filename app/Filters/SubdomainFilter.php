<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class SubdomainFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $host = $_SERVER['HTTP_HOST'];
        $subdomain = explode('.', $host)[0]; // Extract the subdomain

        switch ($subdomain) {
            case 'admin':
                return redirect()->to('/admin');
                break;
            case 'pharmacy':
                return redirect()->to('/pharmacy');
                break;
            case 'driver':
                return redirect()->to('/driver/dashboard');
                break;
            case 'user':
                return redirect()->to('/user/dashboard');
                break;
            default:
                // If no subdomain or unrecognized subdomain, do nothing
                return;
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed after response
    }
}
