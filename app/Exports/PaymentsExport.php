<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaymentsExport implements FromCollection,WithHeadings
{
    protected $payments;

    public function __construct($payments)
    {
        $this->payments = $payments;
    }

    public function collection()
    {
        return $this->payments;
    }

    public function headings(): array
    {
        return [
            'Sl No',
            'Customer_Name',
            'Customer_Phone',
            'Project_Name',
            'Project_Value',
            'Paid',
            'Previous_Due',
            'Current_Amount',
            'Current_Due',
            'Note',
            'Date',
            'Created_By'
        ];
    }
}
