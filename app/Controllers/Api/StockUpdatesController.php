<?php

namespace App\Controllers\Api;

use CodeIgniter\Controller;
use App\Models\PharmacyDrugModel;

class StockUpdatesController extends Controller
{
    protected $pharmacyDrugModel;

    public function __construct()
    {
        $this->pharmacyDrugModel = new PharmacyDrugModel();
    }

    public function stream()
    {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');

        $lastEventId = isset($_SERVER["HTTP_LAST_EVENT_ID"]) ? intval($_SERVER["HTTP_LAST_EVENT_ID"]) : 0;
        $pharmacyId = $this->request->getGet('pharmacy_id');

        while (true) {
            $updates = $this->pharmacyDrugModel->getUpdatedStocks($pharmacyId, $lastEventId);
            
            if (!empty($updates)) {
                foreach ($updates as $update) {
                    $eventId = $update['id'];
                    $data = json_encode($update);
                    echo "id: $eventId\n";
                    echo "data: $data\n\n";
                    ob_flush();
                    flush();
                }
                $lastEventId = $eventId;
            }

            sleep(5); // Wait for 5 seconds before checking for new updates
        }
    }
}
