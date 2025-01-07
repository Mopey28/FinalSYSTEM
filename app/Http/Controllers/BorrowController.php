<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Equipment;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    public function index()
    {
        $borrows = Borrow::with('equipment')->whereNull('return_date')->get();
        $equipment = Equipment::all();
        return view('CET.inventory.borrow.index', compact('borrows', 'equipment'));
    }

    public function create()
    {
        $equipment = Equipment::all();
        return view('CET.inventory.borrow.create', compact('equipment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'student_id' => 'required|string',
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'borrow_date' => 'required|date',
        ]);

        // Check if the student has already borrowed the maximum number of equipment
        $borrowedCount = Borrow::where('student_id', $request->student_id)
                               ->whereNull('return_date')
                               ->count();

        if ($borrowedCount >= 2) {
            return redirect()->route('CET.inventory.borrow.index')->with('error', 'Student has already borrowed the maximum number of equipment.');
        }

        $equipment = Equipment::find($request->equipment_id);

        if ($equipment && $equipment->quantity > 0) {
            $equipment->update([
                'quantity' => $equipment->quantity - 1,
                'status' => 'borrowed',
            ]);

            Borrow::create([
                'equipment_id' => $request->equipment_id,
                'student_id' => $request->student_id,
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'borrow_date' => $request->borrow_date,
            ]);

            return redirect()->route('CET.inventory.borrow.index')->with('success', 'Equipment borrowed successfully.');
        } else {
            return redirect()->route('CET.inventory.borrow.index')->with('error', 'Equipment is not available.');
        }
    }

    public function edit(Borrow $borrow)
    {
        $equipment = Equipment::all();
        return view('CET.inventory.borrow.edit', compact('borrow', 'equipment'));
    }

    public function update(Request $request, Borrow $borrow)
    {
        $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'student_id' => 'required|string',
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'borrow_date' => 'required|date',
        ]);

        $borrow->update([
            'equipment_id' => $request->equipment_id,
            'student_id' => $request->student_id,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'borrow_date' => $request->borrow_date,
        ]);

        return redirect()->route('CET.inventory.borrow.index')->with('success', 'Borrow record updated successfully.');
    }

    public function return(Borrow $borrow)
    {
        $equipment = Equipment::find($borrow->equipment_id);

        if ($equipment) {
            $equipment->update([
                'quantity' => $equipment->quantity + 1,
                'status' => 'available',
            ]);

            $borrow->update([
                'return_date' => now(),
            ]);

            return redirect()->route('CET.inventory.borrow.index')->with('success', 'Equipment returned successfully.');
        } else {
            return redirect()->route('CET.inventory.borrow.index')->with('error', 'Equipment not found.');
        }
    }

    public function destroy(Borrow $borrow)
    {
        $borrow->delete();
        return redirect()->route('CET.inventory.borrow.index')->with('success', 'Borrow record deleted successfully.');
    }

    public function history()
    {
        $borrows = Borrow::with('equipment')->whereNotNull('return_date')->get();
        $equipment = Equipment::all();
        return view('CET.inventory.borrow.history', compact('borrows', 'equipment'));
    }
}
