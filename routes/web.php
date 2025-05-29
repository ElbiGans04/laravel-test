<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth:web'])->group(function () {
    Route::get('/', function (Request $request) {
        // return view('welcome');
        // return User::where('id', '!=', Auth::user()['id'])->get();
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
    })->name('index')->middleware(['permission:users.read']);

    Route::group(['prefix' => '/users', 'as' => 'users.'], function () {
        Route::get('/create', function (Request $request) {
            $data = Role::all();
            return view('users.create', ["data" => $data]);
        })->name('create')->middleware(['permission:users.create']);

        Route::post('/create', function (Request $request) {
            $input = $request->input();
            $user = new User();
            $user->name = $input['name'];
            $user->email = $input['email'];
            $user->password = Hash::make($input['password']);
            $user->save();
            $role = Role::find($input['role']);
            $user->assignRole($role);
            return redirect()->route('index');
        })->name('create.post')->middleware(['permission:users.create']);

        Route::get('/update', function (Request $request) {
            $id = $request->input()['id'];
            $roles = Role::all();
            $data = User::with('roles')->where(['id' => $id])->first();
            return view('users.update', ['data' => $data, "roles" => $roles]);
        })->name('update')->middleware(['permission:users.update']);

        Route::post('/update', function (Request $request) {
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
        })->name('update.post')->middleware(['permission:users.update']);

        Route::get('/delete', function (Request $request) {
            $data = $request->query();
            $found = User::find($data['id']);
            $found->delete();
            return redirect()->route('index');

        })->name('delete')->middleware(['permission:users.delete']);
    });

    Route::group(['prefix' => '/roles', 'as' => 'roles.'], function () {
        Route::get('', function (Request $request) {
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
        })->name('index')->middleware(['permission:roles.read']);

        Route::get('/create', function (Request $request) {
            if ($request->ajax()) {
                $data = Role::query();
                return DataTables::of($data)->make(true);
            }

            $dataPermission = Permission::all();
            return view('roles.create', ["data" => $dataPermission]);
        })->name('create')->middleware(['permission:roles.create']);

        Route::post('/create', function (Request $request) {
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
        })->name('create.post')->middleware(['permission:roles.create']);

        Route::get('/update', function (Request $request) {
            $id = $request->input()['id'];
            $data = Role::find($id);
            $dataPermission = Permission::all();

            $dataAlready = [];
            foreach (collect($data->permissions) as $item) {
                $dataAlready[$item['id']] = 'ok';
            }

            return view('roles.update', ["data" => $data, "permissions" => $dataPermission, "alreadyPermissions" => $dataAlready]);
        })->name('update')->middleware(['permission:roles.update']);

        Route::post('/update', function (Request $request) {
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
        })->name('update.post')->middleware(['permission:roles.update']);


        Route::get('/delete', function (Request $request) {
            $data = $request->query();
            $found = Role::find($data['id']);
            $found->delete();
            return redirect()->route('roles.index');

        })->name('delete')->middleware(['permission:roles.delete']);
    });

    Route::group(['prefix' => '/permissions', 'as' => 'permissions.'], function () {
        Route::get('', function (Request $request) {
            if ($request->ajax()) {
                $data = Permission::query();
                return DataTables::of($data)->make(true);
            }
            return view('permissions.index');
        })->name('index')->middleware(['permission:permissions.read']);

        Route::get('/create', function (Request $request) {
            return view('permissions.create');
        })->name('create')->middleware(['permission:permissions.create']);

        Route::post('/create', function (Request $request) {
            $input = $request->input();
            Permission::create(["name" => $input['name']]);
            return redirect()->route('permissions.index');
        })->name('create.post')->middleware(['permission:permissions.create']);

        Route::get('/update', function (Request $request) {
            $id = $request->input()['id'];
            $data = Permission::find($id);
            return view('permissions.update', ["data" => $data]);
        })->name('update')->middleware(['permission:permissions.update']);

        Route::post('/update', function (Request $request) {
            $input = $request->input();
            $find = Permission::find($input['id']);
            $find['name'] = $input['name'];
            $find->save();
            return redirect()->route('permissions.index');
        })->name('update.post')->middleware(['permission:permissions.update']);

        Route::get('/delete', function (Request $request) {
            $data = $request->query();
            $found = Permission::find($data['id']);
            $found->delete();
            return redirect()->route('permissions.index');

        })->name('delete')->middleware(['permission:permissions.delete']);
    });
});

Route::group(['prefix' => '/auth'], function () {
    Route::get('login', function () {
        return view('auth.login');
    })->name('login');

    Route::get('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->flash('message-type', 'success');
        $request->session()->flash('message', 'Berhasil Keluar. Sampai Jumpa');
        return redirect()->route('login');
    })->name('logout');

    Route::post('/login', function (Request $request) {
        $data = $request->input();
        $try = Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password']
        ]);

        if ($try) {
            $request->session()->regenerate();
            return redirect()->route('index');
        }

        $request->session()->flash('message-type', 'failed');
        $request->session()->flash('message', 'Email / Password yang anda masukan salah');
        return redirect()->route('login');
    })->name('login.post');
});
