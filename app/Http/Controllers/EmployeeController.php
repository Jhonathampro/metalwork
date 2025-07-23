<?php

namespace App\Http\Controllers;
use App\Models\employee;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    public function index()
    {
        try {
            $employees = employee::all();

            return response()->json($employees, 200);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

}
