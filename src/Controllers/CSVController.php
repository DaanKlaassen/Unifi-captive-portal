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

    public function importCSV(): string|bool
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $jsonData = file_get_contents('php://input');
            $data = json_decode($jsonData, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                http_response_code(400);
                return json_encode(['message' => 'Invalid JSON data.']);
            }

            foreach ($data as &$item) {
                if (isset($item['email'])) {
                    $email = $item['email'];
                    $nameParts = explode('@', $email)[0];
                    $fullName = str_replace('.', ' ', $nameParts);
                    $item['name'] = $fullName;
                }
            }

            $result = $this->CSVModel->importCSV($data);

            $jsonDecoded = json_decode($result, true);

            if ($jsonDecoded['success']) {
                http_response_code(200);
                echo json_encode(['message' => $result]);
                exit();
            } else if ($jsonDecoded['error']) {
                http_response_code(500);
                echo json_encode(['message' => "An error occurred while importing data:" . $result]);
                exit();
            }
        }
        return false;
    }
}