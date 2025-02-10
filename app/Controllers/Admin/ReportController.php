<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\PharmacyModel;
use App\Models\DrugModel;
use App\Models\UserModel;
use App\Models\SiteVisitModel;

class ReportController extends BaseController
{
    protected $orderModel;
    protected $pharmacyModel;
    protected $drugModel;
    protected $userModel;
    protected $siteVisitModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->pharmacyModel = new PharmacyModel();
        $this->drugModel = new DrugModel();
        $this->userModel = new UserModel();
        $this->siteVisitModel = new SiteVisitModel();
    }

    public function index()
    {
        $data = [
            'totalSales' => $this->orderModel->getTotalSales(),
            'totalOrders' => $this->orderModel->countAllResults(),
            'totalUsers' => $this->userModel->countAllResults(),
            'totalDrugs' => $this->drugModel->countAllResults(),
            'totalPharmacies' => $this->pharmacyModel->countAllResults(),
            'monthlySales' => $this->orderModel->getMonthlySales(),
            'topSellingDrugs' => $this->orderModel->getTopSellingDrugs(5),
            'revenueByPharmacy' => $this->orderModel->getRevenueByPharmacy(),
            'userGrowth' => $this->userModel->getUserGrowth(),
            'orderCompletionRate' => $this->orderModel->getOrderCompletionRate(),
            'averageOrderValue' => $this->orderModel->getAverageOrderValue(),
            'siteVisits' => $this->siteVisitModel->findAll(),
        ];

        return view('admin/reports/index', $data);
    }

    public function generatePdfReport()
    {
        $data = [
            'totalSales' => $this->orderModel->getTotalSales(),
            'totalOrders' => $this->orderModel->countAllResults(),
            'topSellingDrugs' => $this->orderModel->getTopSellingDrugs(10),
            'revenueByPharmacy' => $this->orderModel->getRevenueByPharmacy(),
        ];

        $html = view('admin/reports/pdf_template', $data);

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('MedFinder_Report.pdf', ['Attachment' => 0]);
    }

    public function exportCsv()
    {
        $data = $this->orderModel->getReportData();

        $filename = 'MedFinder_Report_' . date('Y-m-d') . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");

        $file = fopen('php://output', 'w');

        $header = ['Order ID', 'Date', 'Pharmacy', 'Total Amount', 'Status'];
        fputcsv($file, $header);

        foreach ($data as $row) {
            fputcsv($file, $row);
        }

        fclose($file);
        exit;
    }
}

