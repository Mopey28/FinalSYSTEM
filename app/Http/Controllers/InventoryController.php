<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function book(){
        return view('CET.inventory.book.book-dashboard');
    }
}
