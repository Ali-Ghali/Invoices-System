<?php

namespace App\Imports;

use App\Models\invoices;
use Maatwebsite\Excel\Concerns\ToModel;

class InvoicesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new invoices([
            //
        ]);
    }
}
