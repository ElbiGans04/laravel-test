<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CarController extends Controller
{
    function indexView(Request $request)
    {
        if ($request->ajax()) {
            $data = Car::query();
            return DataTables::of($data)->make(true);
        }
        return view('cars.index');
    }
    function createView(Request $request)
    {
        return view('cars.index');
    }
    function create(Request $request)
    {
        return view('cars.index');
    }
    function updateView(Request $request)
    {
        return view('cars.index');
    }
    function update(Request $request)
    {
        return view('cars.index');
    }
    function delete(Request $request)
    {
        return view('cars.index');
    }
}
