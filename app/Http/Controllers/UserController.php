<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function indexView(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('id', '!=', Auth::user()['id'])->with(['roles', 'roles.permissions'])->get();
            return DataTables::of($data)->addColumn('role', function ($user) {
                return $user->roles->pluck('name')->implode(', ');
            })->addColumn('actions', function ($user) {
                $html = '';
                $data = Auth::user()->roles[0]['permissions'];
                $isAllowUpdate = collect($data)->contains('name', 'users.update');
                $isAllowDelete = collect($data)->contains('name', 'users.delete');

                if ($isAllowUpdate) {
                    $html .= "<a href='" . route('users.update') . "?id=" . $user['id'] . "' class='btn m-1 btn-primary'>Update</a>";
                }
                if ($isAllowDelete) {
                    $html .= "<a href='" . route('users.delete') . "?id=" . $user['id'] . "' class='btn m-1 btn-danger'>Delete</a>";
                }

                return $html;
            })->rawColumns(['actions'])->make(true);
        }

        return view('index');
    }

    public function createView(Request $request)
    {
        $data = Role::all();
        return view('users.create', ["data" => $data]);
    }

    public function create(Request $request)
    {
        $input = $request->input();
        $user = new User();
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = Hash::make($input['password']);
        $user->save();
        $role = Role::find($input['role']);
        $user->assignRole($role);
        return redirect()->route('index');
    }

    public function updateView(Request $request)
    {
        $id = $request->input()['id'];
        $roles = Role::all();
        $data = User::with('roles')->where(['id' => $id])->first();
        return view('users.update', ['data' => $data, "roles" => $roles]);
    }

    public function update(Request $request)
    {
        $input = $request->input();
        $find = User::find($input['id']);
        $find->name = $input['name'];
        $find->email = $input['email'];
        $find->password = Hash::make($input['password']);
        $find->save();

        $haveRole = Role::find($find->roles[0]['id']);
        $newRole = Role::find($input['role']);
        $changeRole = $input['role'] != $find->roles[0]['id'];
        if ($changeRole) {
            $find->removeRole($haveRole);
            $find->assignRole($newRole);

        }

        return redirect()->route('index');
    }

    public function delete(Request $request)
    {
        $data = $request->query();
        $found = User::find($data['id']);
        $found->delete();
        return redirect()->route('index');
    }
}
