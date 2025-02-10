<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\SiteVisitModel;
use GeoIp2\Database\Reader;
use CodeIgniter\Log\Logger;

class SiteVisitLogger implements FilterInterface
{
    protected $logger;

    public function __construct()
    {
        $this->logger = service('logger');
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        // Exclude visits by super_admin or admin
        $session = session();
        if ($session->get('role') === 'super_admin' || $session->get('role') === 'admin') {
            $this->logger->info('Visit excluded for role: ' . $session->get('role'));
            return;
        }

        $siteVisitModel = new SiteVisitModel();

        $locationData = $this->getUserLocation($request->getIPAddress());

        $data = [
            'visit_date' => date('Y-m-d'),
            'visits' => 1,
            'user_location' => $locationData['location'],
            'latitude' => $locationData['latitude'],
            'longitude' => $locationData['longitude'],
            'device_type' => $this->getDeviceType(),
            'referral_source' => $this->getReferralSource(),
            'time_spent' => 0, // This will be updated after the response
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->logger->info('Site visit data: ' . json_encode($data));

        $existingVisit = $siteVisitModel->where('visit_date', $data['visit_date'])
                                        ->where('user_location', $data['user_location'])
                                        ->where('device_type', $data['device_type'])
                                        ->where('referral_source', $data['referral_source'])
                                        ->first();

        if ($existingVisit) {
            $siteVisitModel->update($existingVisit['id'], ['visits' => $existingVisit['visits'] + 1, 'updated_at' => date('Y-m-d H:i:s')]);
            $session->set('visit_id', $existingVisit['id']);
            $this->logger->info('Updated existing visit ID: ' . $existingVisit['id']);
        } else {
            $siteVisitModel->insert($data);
            $session->set('visit_id', $siteVisitModel->getInsertID());
            $this->logger->info('Inserted new visit ID: ' . $siteVisitModel->getInsertID());
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Update the time spent on the page
        $siteVisitModel = new SiteVisitModel();
        $visitId = session()->get('visit_id');
        if ($visitId) {
            $siteVisitModel->update($visitId, ['time_spent' => time() - session()->get('visit_start_time')]);
            $this->logger->info('Updated time spent for visit ID: ' . $visitId);
        }
    }

    private function getUserLocation($ipAddress)
    {
        // Handle local IP addresses
        if ($ipAddress === '127.0.0.1' || $ipAddress === '::1') {
            return [
                'location' => 'Localhost',
                'latitude' => null,
                'longitude' => null,
            ];
        }

        try {
            $reader = new Reader('D:/xampp/htdocs/MedFinder/assets/geolite/GeoLite2-City.mmdb'); // Path to the GeoLite2 database
            $record = $reader->city($ipAddress);
            $location = $record->city->name . ', ' . $record->country->name;
            $latitude = $record->location->latitude;
            $longitude = $record->location->longitude;

            if (empty($location)) {
                $location = 'Unknown';
            }

            return [
                'location' => $location,
                'latitude' => $latitude,
                'longitude' => $longitude,
            ];
        } catch (\Exception $e) {
            $this->logger->error('GeoIP2 error: ' . $e->getMessage());
            echo 'GeoIP2 error: ' . $e->getMessage(); // Display error on screen for debugging
            return [
                'location' => 'Unknown',
                'latitude' => null,
                'longitude' => null,
            ];
        }
    }

    private function getDeviceType()
    {
        $agent = service('request')->getUserAgent();
        $platform = $agent->getPlatform(); // e.g., Windows, Android, iOS
        $browser = $agent->getBrowser(); // e.g., Chrome, Firefox, Safari
        $version = $agent->getVersion(); // e.g., 89.0, 14.0

        return $platform . ' on ' . $browser . ' ' . $version;
    }

    private function getReferralSource()
    {
        return service('request')->getServer('HTTP_REFERER') ?? 'Direct';
    }
}
