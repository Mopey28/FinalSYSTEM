<?php

use App\Http\Controllers\BorrowController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\StudentInformationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/CET-dashboard', function () {
    return view('CET.dashboard');
})->middleware(['auth', 'verified'])->name('CET.dashboard');

Route::get('CET/dashboard', [dashboardController::class, 'dashboard'])->name('CET.dashboard');

// Books Routes
Route::get('CET/Inventory/Book-Dashboard', [BookController::class, 'book'])->name('CET.inventory.book.book-dashboard');
Route::get('CET/Inventory/Book/Create', [BookController::class, 'create'])->name('CET.inventory.book.create'); // Create form
Route::post('CET/Inventory/Book/Store', [BookController::class, 'store'])->name('CET.inventory.book.store'); // Store new book
Route::get('CET/Inventory/Book/Edit/{id}', [BookController::class, 'edit'])->name('CET.inventory.book.edit'); // Edit form
Route::put('CET/Inventory/Book/Update/{id}', [BookController::class, 'update'])->name('CET.inventory.book.update');
Route::delete('CET/Inventory/Book/Delete/{id}', [BookController::class, 'destroy'])->name('CET.inventory.book.destroy'); // Delete book
Route::post('/books/import', [BookController::class, 'import'])->name('CET.inventory.book.import');

// Routes for Book Borrowers
Route::get('CET/Inventory/Book/Borrowers', [BorrowerController::class, 'index'])->name('CET.inventory.borrowers.index'); // Borrowers page
Route::post('CET/Inventory/Book/Borrowers/Store', [BorrowerController::class, 'store'])->name('CET.inventory.borrowers.store'); // Borrow book
Route::patch('/book/borrowers/{id}/return', [BorrowerController::class, 'setReturn'])->name('CET.inventory.borrowers.return');
Route::get('/book/borrowers/history', [BorrowerController::class, 'history'])->name('CET.inventory.borrowers.history');

Route::get('CET/student-dashboard', [StudentInformationController::class, 'studentInformation'])->name('CET.student_information.student-dashboard');

// Equipment Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('CET/Inventory/Equipment', [EquipmentController::class, 'index'])->name('CET.inventory.equipment.equipment-dashboard');
    Route::get('CET/Inventory/Equipment/create', [EquipmentController::class, 'create'])->name('CET.inventory.equipment.create');
    Route::post('CET/Inventory/Equipment', [EquipmentController::class, 'store'])->name('CET.inventory.equipment.store');
    Route::get('CET/Inventory/Equipment/{equipment}', [EquipmentController::class, 'show'])->name('CET.inventory.equipment.show');
    Route::get('CET/Inventory/Equipment/{equipment}/edit', [EquipmentController::class, 'edit'])->name('CET.inventory.equipment.edit');
    Route::put('CET/Inventory/Equipment/{equipment}', [EquipmentController::class, 'update'])->name('CET.inventory.equipment.update');
    Route::delete('CET/Inventory/Equipment/{equipment}', [EquipmentController::class, 'destroy'])->name('CET.inventory.equipment.destroy');
    Route::get('CET/Inventory/Equipment/export', [EquipmentController::class, 'export'])->name('CET.inventory.equipment.export');
    Route::post('CET/Inventory/Equipment/import', [EquipmentController::class, 'import'])->name('CET.inventory.equipment.import');

    Route::get('CET/Inventory/Borrow', [BorrowController::class, 'index'])->name('CET.inventory.borrow.index');
    Route::get('CET/Inventory/Borrow/create', [BorrowController::class, 'create'])->name('CET.inventory.borrow.create');
    Route::post('CET/Inventory/Borrow', [BorrowController::class, 'store'])->name('CET.inventory.borrow.store');
    Route::get('CET/Inventory/Borrow/{borrow}/edit', [BorrowController::class, 'edit'])->name('CET.inventory.borrow.edit');
    Route::put('CET/Inventory/Borrow/{borrow}', [BorrowController::class, 'update'])->name('CET.inventory.borrow.update');
    Route::post('CET/Inventory/Borrow/{borrow}/return', [BorrowController::class, 'return'])->name('CET.inventory.borrow.return');
    Route::delete('CET/Inventory/Borrow/{borrow}', [BorrowController::class, 'destroy'])->name('CET.inventory.borrow.destroy');
    Route::get('CET/Inventory/Borrow/history', [BorrowController::class, 'history'])->name('CET.inventory.borrow.history');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
