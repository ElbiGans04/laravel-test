<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    function indexView(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::with('permissions');
            return DataTables::of($data)->addColumn('permissions', function ($role) {
                if (count($role->permissions) > 0) {
                    $html = "";
                    foreach (collect($role->permissions->pluck('name')) as $item) {
                        $html .= "<span class='badge badge-primary m-1'>" . $item . "</span>";
                    }

                    return $html;
                }

                return '';
            })->addColumn('actions', function ($user) {
                $html = '';
                $data = Auth::user()->roles[0]['permissions'];
                $isAllowUpdate = collect($data)->contains('name', 'roles.update');
                // $isAllowDelete = collect($data)->contains('name', 'roles.delete');

                if ($isAllowUpdate) {
                    $html .= "<a href='" . route('roles.update') . "?id=" . $user['id'] . "' class='btn m-1 btn-primary'>Update</a>";
                }
                // if ($isAllowDelete) {
                //     $html .= "<a href='" . route('roles.delete') . "?id=" . $user['id'] . "' class='btn m-1 btn-danger'>Delete</a>";
                // }

                return $html;
            })->rawColumns(['permissions', 'actions'])->make(true);
        }
        return view('roles.index');
    }

    function createView(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::query();
            return DataTables::of($data)->make(true);
        }

        $dataPermission = Permission::all();
        return view('roles.create', ["data" => $dataPermission]);
    }

    function create(Request $request)
    {
        $dataInput = collect($request->input());
        $dataFilter = $dataInput->filter(function ($value, $index) {
            return strpos($index, 'permission-') !== false;
        })->keys()->map(function ($item) {
            return explode('permission-', $item)[1];
        });

        // Create Role
        $newRole = new Role();
        $newRole->name = $dataInput['name'];
        $newRole->save();

        // Looping Search Data
        foreach ($dataFilter as $item) {
            $permission = Permission::findById($item);
            $newRole->givePermissionTo($permission);

        }

        return redirect()->route('roles.index');
    }

    function update(Request $request)
    {
        $dataInput = collect($request->input());
        // Permission Yang Dikirim kalau ada [5,2,1]
        $dataFilter = $dataInput->filter(function ($value, $index) {
            return strpos($index, 'permission-') !== false;
        })->keys()->map(function ($item) {
            return explode('permission-', $item)[1];
        });
        // return $dataFilter;

        $find = Role::find($dataInput['id']);
        $find->name = $dataInput['name'];
        $find->save();
        // [{}]
        $alreadyHavePermission = collect($find->permissions);

        // Check Permission Yang Di Hapus
        $removePermission = [];
        foreach ($alreadyHavePermission as $item) {
            if ($dataFilter->search($item['id']) === false) {
                $removePermission[] = $item['id'];
            }
        }

        // Hapus Permissionnya jika dinonaktifkan
        foreach ($removePermission as $item) {
            $itemModel = Permission::findById($item);
            $find->revokePermissionTo($itemModel);
        }

        // Harus cari tau gimana ketika ada item yang sudah di assign
        foreach ($dataFilter as $item) {
            if ($alreadyHavePermission->contains('id', $item) === false) {
                $itemModel = Permission::findById($item);
                $find->givePermissionTo($itemModel);
            }
        }

        return redirect()->route('roles.index');
    }

    function updateView(Request $request)
    {
        $id = $request->input()['id'];
        $data = Role::find($id);
        $dataPermission = Permission::all();

        $dataAlready = [];
        foreach (collect($data->permissions) as $item) {
            $dataAlready[$item['id']] = 'ok';
        }

        return view('roles.update', ["data" => $data, "permissions" => $dataPermission, "alreadyPermissions" => $dataAlready]);
    }

    function delete(Request $request)
    {
        $data = $request->query();
        $found = Role::find($data['id']);
        $found->delete();
        return redirect()->route('roles.index');
    }
}
