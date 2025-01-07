<?php

namespace App\Imports;

use App\Models\Equipment;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EquipmentImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Equipment([
            'description' => $row['description'],
            'quantity' => $row['quantity'],
            'brand_model' => $row['brand_model'],
            'engine_serial_no' => $row['engine_serial_no'],
            'inventory_tag_no' => $row['inventory_tag_no'],
            'purchased_by' => $row['purchased_by'],
            'remarks' => $row['remarks'],
            'status' => $row['status'],
        ]);
    }
}
