<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EquipmentExport;
use Exception;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipment = Equipment::all();
        return view('CET.inventory.equipment.equipment-dashboard', compact('equipment'));
    }

    public function create()
    {
        return view('CET.inventory.equipment.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0', // Ensure quantity is required, validated, and not negative
            'description' => 'nullable',
            'brand_model' => 'nullable',
            'engine_serial_no' => 'nullable|unique:equipment',
            'inventory_tag_no' => 'nullable|unique:equipment',
            'purchased_by' => 'required',
            'remarks' => 'nullable',
            'status' => 'nullable', // Add status field validation
        ]);

        try {
            Equipment::create($request->all());
            return redirect()->route('CET.inventory.equipment.equipment-dashboard')->with('success', 'Equipment added successfully.');
        } catch (Exception $e) {
            \Log::error('Failed to add equipment: ' . $e->getMessage());
            return redirect()->route('CET.inventory.equipment.equipment-dashboard')->with('error', 'Failed to add equipment.');
        }
    }

    public function show(Equipment $equipment)
    {
        return view('CET.inventory.equipment.show', compact('equipment'));
    }

    public function edit(Equipment $equipment)
    {
        return view('CET.inventory.equipment.edit', compact('equipment'));
    }

    public function update(Request $request, Equipment $equipment)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0', // Ensure quantity is required, validated, and not negative
            'description' => 'nullable',
            'brand_model' => 'nullable',
            'engine_serial_no' => 'nullable|unique:equipment,engine_serial_no,' . $equipment->id,
            'inventory_tag_no' => 'nullable|unique:equipment,inventory_tag_no,' . $equipment->id,
            'purchased_by' => 'required',
            'remarks' => 'nullable',
            'status' => 'nullable', // Add status field validation
        ]);

        try {
            $equipment->update($request->all());
            return redirect()->route('CET.inventory.equipment.equipment-dashboard')->with('success', 'Equipment updated successfully.');
        } catch (Exception $e) {
            return redirect()->route('CET.inventory.equipment.equipment-dashboard')->with('error', 'Failed to update equipment.');
        }
    }

    public function destroy(Equipment $equipment)
    {
        try {
            $equipment->delete();
            return redirect()->route('CET.inventory.equipment.equipment-dashboard')->with('success', 'Equipment deleted successfully.');
        } catch (Exception $e) {
            return redirect()->route('CET.inventory.equipment.equipment-dashboard')->with('error', 'Failed to delete equipment.');
        }
    }

    public function export()
    {
        return Excel::download(new EquipmentExport, 'equipment.xlsx');
    }

    public function import(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        // Load and parse the CSV file
        $file = $request->file('csv_file');
        $data = array_map('str_getcsv', file($file->getRealPath()));

        // Ensure the file contains at least one row of data
        if (count($data) < 1) {
            return redirect()->back()->with('error', 'The CSV file is empty.');
        }

        // Loop through each row and create equipment
        foreach ($data as $index => $row) {
            // Skip the header row
            if ($index === 0) continue;

            // Ensure the row has the expected columns
            if (count($row) >= 8) {
                Equipment::create([
                    'description' => $row[0],
                    'quantity' => max(0, intval($row[1])), // Ensure quantity is not negative
                    'brand_model' => $row[2],
                    'engine_serial_no' => $row[3],
                    'inventory_tag_no' => $row[4],
                    'purchased_by' => $row[5],
                    'remarks' => $row[6],
                    'status' => $row[7],
                ]);
            }
        }

        // Redirect back to the equipment dashboard with a success message
        return redirect()->route('CET.inventory.equipment.equipment-dashboard')->with('success', 'Equipment imported successfully!');
    }
}
