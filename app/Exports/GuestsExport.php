<?php

namespace App\Exports;

use App\Models\Guest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GuestsExport implements FromCollection, WithHeadings
{

    public function __construct()
    {
        
    }
    /**
     * @return \Illuminate\Support\Collection
     */

    public function headings(): array
    {
        return [
            'id',
            'nama',
            'nip',
            'unit',
            'phone',
            'description',
            'created_at',
            'updated_at',
            'deleted_at',
        ];
    }
    public function collection()
    {
        return Guest::withTrashed()->get();
    }
}
