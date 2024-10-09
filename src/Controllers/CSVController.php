<?php

namespace App\Controllers;

use App\Models\CSVModel;

class CSVController
{
    private $CSVModel;
    public function __construct()
    {
        $this->CSVModel = new CSVModel();
    }

    public function exportCSV()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = file_get_contents('php://input');

            $CSVData = $this->CSVModel->exportCSV($data);

            if ($CSVData === false) {
                http_response_code(400);
                echo json_encode(['message' => 'No data to export.']);
                return json_encode(['message' => 'No data to export.']);
            } else {
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="export.csv"');
                header('Pragma: no-cache');
                header('Expires: 0');

                // Output the CSV data
                echo $CSVData;

                exit();
            }
        }
    }

    public function importCSV(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $jsonData = file_get_contents('php://input');
            $data = json_decode($jsonData, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                http_response_code(400);
                echo json_encode(['message' => 'Invalid JSON data.']);
                return;
            }

            $result = $this->CSVModel->importCSV($data);

            if ($result === false) {
                http_response_code(500);
                echo json_encode(['message' => 'Failed to import data.']);
            } else {
                http_response_code(200);
                echo json_encode(['message' => 'Data imported successfully.']);
            }
        }
    }
}
