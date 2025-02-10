<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PharmacyDrugModel;

class StockController extends BaseController
{
  protected $pharmacyDrugModel;

  public function __construct()
  {
      $this->pharmacyDrugModel = new PharmacyDrugModel();
  }

  public function uploadCSV()
  {
      $validationRule = [
          'stock_csv' => [
              'label' => 'CSV File',
              'rules' => 'uploaded[stock_csv]|ext_in[stock_csv,csv]',
          ],
      ];

      if (!$this->validate($validationRule)) {
          return $this->response->setJSON([
              'success' => false,
              'error' => $this->validator->getErrors()
          ]);
      }

      $file = $this->request->getFile('stock_csv');

      if ($file->isValid() && !$file->hasMoved()) {
          $newName = $file->getRandomName();
          $file->move(WRITEPATH . 'uploads', $newName);

          $csvData = array_map('str_getcsv', file(WRITEPATH . 'uploads/' . $newName));
          $headers = array_shift($csvData);

          return $this->response->setJSON([
              'success' => true,
              'message' => 'CSV uploaded successfully',
              'headers' => $headers,
              'filename' => $newName
          ]);
      }

      return $this->response->setJSON([
          'success' => false,
          'error' => 'Failed to upload CSV file.'
      ]);
  }

  public function mapColumns()
  {
      $mapping = $this->request->getPost('mapping');
      $filename = $this->request->getPost('filename');
      $pharmacyId = $this->request->getPost('pharmacy_id');

      $csvData = array_map('str_getcsv', file(WRITEPATH . 'uploads/' . $filename));
      array_shift($csvData); // Remove headers

      $stockData = [];
      foreach ($csvData as $row) {
          $stockItem = [];
          foreach ($mapping as $field => $index) {
              $stockItem[$field] = $row[$index];
          }
          $stockItem['pharmacy_id'] = $pharmacyId;
          $stockData[] = $stockItem;
      }

      $this->pharmacyDrugModel->insertBatch($stockData);

      return $this->response->setJSON([
          'success' => true,
          'message' => 'Stock data imported successfully'
      ]);
  }
  public function updateExistingStock()
  {
      $validationRule = [
          'stock_csv' => [
              'label' => 'CSV File',
              'rules' => 'uploaded[stock_csv]|ext_in[stock_csv,csv]',
          ],
      ];

      if (!$this->validate($validationRule)) {
          return $this->response->setJSON([
              'success' => false,
              'error' => $this->validator->getErrors()
          ]);
      }

      $file = $this->request->getFile('stock_csv');

      if ($file->isValid() && !$file->hasMoved()) {
          $newName = $file->getRandomName();
          $file->move(WRITEPATH . 'uploads', $newName);

          $csvData = array_map('str_getcsv', file(WRITEPATH . 'uploads/' . $newName));
          $headers = array_shift($csvData);

          $pharmacyId = $this->request->getPost('pharmacy_id');

          foreach ($csvData as $row) {
              $drugName = $row[0]; // Assuming drug name is in the first column
              $newStock = $row[1]; // Assuming new stock is in the second column

              $this->pharmacyDrugModel->updateStockByDrugName($pharmacyId, $drugName, $newStock);
          }

          return $this->response->setJSON([
              'success' => true,
              'message' => 'Stock levels updated successfully'
          ]);
      }

      return $this->response->setJSON([
          'success' => false,
          'error' => 'Failed to upload CSV file.'
      ]);
  }
}

