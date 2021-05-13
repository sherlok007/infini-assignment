<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExport implements FromCollection
{
    public function headings():array{
        return [
            'id',
            'first_name',
            'last_name',
            'mobile',
            'email_address',
            'srcname',
            'stsname'
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //return Customer::all();
        return collect(Customer::getCustomer());
    }
}
