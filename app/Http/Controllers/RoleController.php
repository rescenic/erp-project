<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        return view('pages.role.index');
    }


    public function data(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::all();

            return datatables()->of($roles)
                ->addColumn('permission', function ($role) {
                    $permissions = '';
                    foreach ($role->getPermissionNames() as $permission) {
                        $permissions .= '<button class="btn btn-sm btn-success mb-1 mt-1 mr-1">' . $permission . '</button>';
                    }
                    return $permissions;
                })
                ->addColumn('aksi', function ($role) {
                    $button = '<div class="dropdown d-inline mr-2"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-sm fa-edit"></i> Aksi
                        </button>';

                    $button .= ' <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                            <a class="dropdown-item" href="'.route('role.edit', $role->id).'">Edit</a>
                            <a class="dropdown-item hapus" href="javascript:void(0)" data-id="' . $role->id . '">Hapus</a>
                        </div></div>';

                    return $button;
                })
                ->addIndexColumn()
                ->rawColumns(['aksi', 'permission'])
                ->toJson();
        }
    }

    public function tambah()
    {
        return view('pages.role.tambah');
    }

    public function listPermission(Request $request)
    {
        if ($request->has('q')) {
            $search = $request->q;

            $result = [];
            $data = DB::table('permissions')
                ->select('*')
                ->where('name', 'LIKE', "%$search%")
                ->get();

            foreach ($data as $d) {
                $result[] = [
                    'id' => $d->id,
                    'text' => $d->name
                ];
            }

            return response()->json($result);
        } else {
            $result = [];
            $data = DB::table('permissions')
                ->select('*')
                ->get();

            foreach ($data as $d) {
                $result[] = [
                    'id' => $d->id,
                    'text' => $d->name
                ];
            }

            return response()->json($result);
        }
    }

    public function simpan(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'role' => 'required',
            'permission' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error validation',
                'error' => $validator->errors()
            ]);
        }

        DB::beginTransaction();

        try {
            $role = new Role();
            $role->name = $request->role;
            $role->save();


            $role->syncPermissions($request->permission);

            DB::commit();

            if ($role) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data disimpan',
                    'data' => $role
                ]);
            }
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage()
            ]);
        }
    }


    public function edit($id)
    {
        $role = Role::find($id);

        return view('pages.role.edit', [
            'role' => $role
        ]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'role' => 'required',
            'permission' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $role = Role::find($request->id);
            $role->name = $request->role;
            $role->save();


            $role->syncPermissions($request->permission);

            DB::commit();

            if ($role) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data diubah',
                    'data' => $role
                ]);
            }
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage()
            ]);
        }
    }


    public function listPermissionsByRole(Request $request)
    {
        $data = DB::table('permissions')
            ->select('permissions.*')
            ->join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->join('roles', 'role_has_permissions.role_id', '=', 'roles.id')
            ->where('roles.id', $request->role_id)
            ->get();

        return response()->json($data);
    }

    public function hapus(Request $request)
    {
        $role = Role::find($request->id);

        $role->delete();

        if ($role) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data dihapus',
            ]);
        }
    }
}
