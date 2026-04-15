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
        // Find or create customer
        $customer = Customer::firstOrCreate(
            ['email' => $row['customer_email']],
            ['name' => $row['customer_name']]
        );

        return new Invoice([
            'invoice_no' => $row['invoice_no'],
            'invoice_date' => Carbon::parse($row['invoice_date']),
            'customer_id' => $customer->id,
            'amount' => $row['invoice_amount'],
            'status' => 'Pending',
        ]);
    }
}
