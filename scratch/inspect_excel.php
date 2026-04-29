<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$inputFileName = 'public/invoice.xlsx';
$spreadsheet = IOFactory::load($inputFileName);
$worksheet = $spreadsheet->getActiveSheet();
$rows = $worksheet->toArray();
$headings = $rows[0];

echo "Headings found: " . implode(', ', $headings) . "\n";
echo "First row of data: " . implode(', ', $rows[1] ?? []) . "\n";
