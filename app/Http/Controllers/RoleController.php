<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $role = Role::latest()->when(request()->q, function ($role) {
            $role = $role->where('name', 'like', '%' . request()->q . '%');
        })->paginate(10);

        return view('pages.role.index', compact('role'));
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

            $data = Permission::select('*')->where('name', 'LIKE', '%' . $search . '%')->get();

            foreach ($data as $d) {
                $result = [
                    'id' => $d->id,
                    'text' => $d->name
                ];
            }

            return response()->json($result);
        }
    }

    public function simpan(Request $request)
    {
        $this->validate($request, [
            'role' => 'required',
            'permission' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $role = new Role();
            $role->name = $request->role;
            $role->save();


            $role->syncPermissions($request->permissions);

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


            $role->syncPermissions($request->permissions);

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
