<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function about()
    {
        $data['title'] = 'About Us';
        return view('pages/about', $data);
    }

    public function faqs()
    {
        $data['title'] = 'Frequently Asked Questions';
        return view('pages/faqs', $data);
    }

    public function contact()
    {
        $data['title'] = 'Contact Us';
        return view('pages/contact', $data);
    }
    public function privacyPolicy()
    {
        return view('pages/privacy_policy');
    }
    public function termsAndConditions()
    {
        $data['title'] = 'Terms and Conditions';
        return view('pages/terms_and_conditions', $data);
    }
}

