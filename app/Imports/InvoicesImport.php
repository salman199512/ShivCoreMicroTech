<?php
namespace App\Imports;

use App\Models\Invoice;
use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class InvoicesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Skip empty rows
        if (!isset($row['invoice_no']) || empty($row['invoice_no'])) {
            return null;
        }

        // Find or create customer
        $customer = Customer::firstOrCreate(
            ['email' => $row['email']],
            ['name' => $row['name']]
        );

        // Handle date parsing
        $invoiceDate = $row['invoice_date'];
        if (is_numeric($invoiceDate)) {
            $invoiceDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($invoiceDate);
        } else {
            $invoiceDate = Carbon::parse($invoiceDate);
        }

        return new Invoice([
            'invoice_no' => $row['invoice_no'],
            'invoice_date' => $invoiceDate,
            'customer_id' => $customer->id,
            'amount' => str_replace(',', '', $row['amount']),
            'status' => 'Pending',
        ]);
    }
}
