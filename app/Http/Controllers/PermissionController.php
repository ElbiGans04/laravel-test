<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class PermissionController extends Controller
{
    function indexView(Request $request)
    {
        if ($request->ajax()) {
            $data = Permission::query();
            return DataTables::of($data)->make(true);
        }
        return view('permissions.index');
    }

    function createView(Request $request)
    {
        return view('permissions.create');
    }
    function create(Request $request)
    {
        $input = $request->input();
        Permission::create(["name" => $input['name']]);
        return redirect()->route('permissions.index');
    }
    function updateView(Request $request)
    {
        $id = $request->input()['id'];
        $data = Permission::find($id);
        return view('permissions.update', ["data" => $data]);
    }
    function update(Request $request)
    {
        $input = $request->input();
        $find = Permission::find($input['id']);
        $find['name'] = $input['name'];
        $find->save();
        return redirect()->route('permissions.index');
    }
    function delete(Request $request)
    {
        $data = $request->query();
        $found = Permission::find($data['id']);
        $found->delete();
        return redirect()->route('permissions.index');
    }
}
