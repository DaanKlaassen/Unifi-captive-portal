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
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = file_get_contents('php://input');

            $CSVData = $this->CSVModel->exportCSV($data);

            if($CSVData === false) {
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

    }
}