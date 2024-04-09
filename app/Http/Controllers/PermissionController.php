<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permission = Permission::paginate(10);

        return view('pages.permission.index', compact('permission'));
    }

    public function tambah()
    {
        return view('pages.permission.tambah');
    }

    public function simpan(Request $request)
    {
        $permission = new Permission();
        $permission->name = $request->permission;
        $permission->save();

        if ($permission) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data disimpan',
                'data' => $permission
            ]);
        }
    }


    public function edit($id)
    {
        $permission = Permission::findOrFail($id);

        return view('pages.permission.edit', [
            'permission' => $permission
        ]);
    }


    public function update(Request $request)
    {
        $permission = Permission::find($request->id);

        $permission->name = $request->permission;
        $permission->save();

        if ($permission) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data diubah',
                'data' => $permission
            ]);
        }
    }

    public function hapus(Request $request)
    {
        $permission = Permission::find($request->id);

        $permission->delete();

        if ($permission) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data dihapus',
            ]);
        }
    }
}
