<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(site_url('admin/login'))
                ->with('error', 'Please login as administrator first.');
        }

        if (session()->get('user_role') !== 'admin') {
            return redirect()->to(site_url('/'))
                ->with('error', 'You do not have permission to access this page.');
        }

        return null;
    }

    public function after(
        RequestInterface $request,
        ResponseInterface $response,
        $arguments = null
    ) {
        // No action needed.
    }
}